import org.junit.*;
import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.remote.RemoteWebDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

import java.util.List;

public class ChromeTests {
    static RemoteWebDriver driver;
    private static Runnable waitForRedirect;

    @BeforeClass
    public static void before() throws IllegalAccessException, InstantiationException {
        initialize(ChromeDriver.class, "chrome", () -> {
        });
    }

    @AfterClass
    public static void after() {
        logout();
        driver.quit();
    }

    @Before
    public void beforeTest() {
        driver.get("https://spicymemes.cs.ut.ee");
    }

    @Test
    public void loadMemes() {
        int memeCount = driver.findElementsByClassName("meme-container").size();
        driver.executeScript("window.scrollTo(0, document.body.scrollHeight);");
        new WebDriverWait(driver, 10).until(ExpectedConditions.numberOfElementsToBeMoreThan(By.className("meme-container"), memeCount));
    }

    @Test
    public void voteMeme() {
        WebElement memeContainer = driver.findElementsByClassName("meme-container").get(0);
        WebElement upvote = memeContainer.findElement(By.className("upvote"));
        WebElement downvote = memeContainer.findElement(By.className("downvote"));

        Assert.assertEquals(0, memeContainer.findElements(By.className("active")).size());

        upvote.click();
        new WebDriverWait(driver, 10).until(ExpectedConditions.attributeContains(upvote, "class", "active"));

        downvote.click();
        new WebDriverWait(driver, 10).until(ExpectedConditions.attributeContains(downvote, "class", "active"));

        downvote.click();
        new WebDriverWait(driver, 10).until(ExpectedConditions.not(ExpectedConditions.attributeContains(downvote, "class", "active")));

        Assert.assertEquals(0, memeContainer.findElements(By.className("active")).size());
    }

    @Test
    public void writeAndVoteComment() {
        driver.findElementsByClassName("meme-container").get(0).findElement(By.tagName("a")).click();
        waitForRedirect.run();

        // Leave some comments
        for (int i = 0; i < 5; ++i) {
            driver.findElementById("comment").sendKeys("Autotest comment xD [" + (i + 1) + "]");
            driver.findElementById("submitComment").submit();
            waitForRedirect.run();
        }

        // Test (up|down)voting on the first comment
        WebElement firstComment = driver.findElementByXPath("//a[contains(concat(' ', @class, ' '), ' user-comments ')]/..");
        WebElement upvote = firstComment.findElement(By.className("upvote"));
        WebElement downvote = firstComment.findElement(By.className("downvote"));

        Assert.assertEquals(0, firstComment.findElements(By.className("active")).size());

        upvote.click();
        new WebDriverWait(driver, 10).until(ExpectedConditions.attributeContains(upvote, "class", "active"));

        downvote.click();
        new WebDriverWait(driver, 10).until(ExpectedConditions.not(ExpectedConditions.attributeContains(downvote, "class", "active")));

        downvote.click();
        new WebDriverWait(driver, 10).until(ExpectedConditions.not(ExpectedConditions.not(ExpectedConditions.attributeContains(downvote, "class", "active"))));

        Assert.assertEquals(0, firstComment.findElements(By.className("active")).size());

        // Delete all comments left by user `autotest`
        while (true) {
            List<WebElement> autotestComments = driver.findElementsByXPath("//a[contains(concat(' ', @class, ' '), ' user-comments ') and . = 'autotest']/..");

            if (autotestComments.size() == 0) {
                break;
            }

            autotestComments.get(0).findElement(By.id("deleteComment")).click();
            waitForRedirect.run();
        }
    }

    @Test
    public void addMemes() {
        driver.findElementByClassName("addsomespice-button").click();
        waitForRedirect.run();

        driver.findElementByName("title").sendKeys("Autotest YouTube");
        driver.findElementByName("link").sendKeys("https://www.youtube.com/watch?v=WBu2pJpgKEo");
        driver.findElementByXPath("//input[@value='Submit']").click();
        waitForRedirect.run();

        driver.findElementByClassName("addsomespice-button").click();
        waitForRedirect.run();

        driver.findElementByName("title").sendKeys("Autotest Image");
        driver.findElementByName("link").sendKeys("http://www.amautaspanish.com/blog/wp-content/uploads/2015/10/translations-of-the-word-ok-2.jpg");
        driver.findElementByXPath("//input[@value='Submit']").click();
        waitForRedirect.run();

        // Check if these posts exist in new
        driver.findElementByClassName("new").click();
        waitForRedirect.run();

        List<WebElement> elements = driver.findElementsByClassName("meme-container");
        Assert.assertTrue(elements.get(0).findElements(By.xpath("//h2[. = 'Autotest Image']")).size() > 0);
        Assert.assertTrue(elements.get(1).findElements(By.xpath("//h2[. = 'Autotest YouTube']")).size() > 0);
    }

    @Test
    public void search() {
        driver.findElementById("srch").sendKeys("Autotest");
        driver.findElementByXPath("//button[@type='submit']").click();
        waitForRedirect.run();

        List<WebElement> autotestUploads = driver.findElementsByXPath("//a[. = 'autotest']/../../..");

        Assert.assertTrue("Found autotest uploads", autotestUploads.size() > 0);
    }

    @Test
    public void languageChange() {
        driver.findElementByClassName("changelanguage").findElement(By.xpath("//a[. = 'EST']")).click();
        waitForRedirect.run();
        Assert.assertEquals("et", driver.findElementByTagName("html").getAttribute("lang"));

        driver.findElementByClassName("changelanguage").findElement(By.xpath("//a[. = 'ENG']")).click();
        waitForRedirect.run();
        Assert.assertEquals("en", driver.findElementByTagName("html").getAttribute("lang"));
    }

    static void initialize(Class driverClass, String name, Runnable runnable) throws IllegalAccessException, InstantiationException {
        System.setProperty("webdriver." + name + ".driver", "./drivers/" + name + "driver.exe");

        driver = (RemoteWebDriver) driverClass.newInstance();
        driver.get("https://spicymemes.cs.ut.ee");

        waitForRedirect = runnable;

        login("autotest", "autotest");
    }

    private static void login(String username, String password) {
        driver.findElement(By.xpath("//ul[contains(concat(' ', @class, ' '), ' loginsignup ')]/li[1]")).click();
        new WebDriverWait(driver, 10).until(ExpectedConditions.visibilityOf(driver.findElement(By.id("signuploginmodal"))));

        driver.findElementByName("username").sendKeys(username);
        driver.findElementByName("password").sendKeys(password);
        driver.findElement(By.xpath("//button[contains(concat(' ', @class, ' '), ' btn-login ')]")).click();

        waitForRedirect.run();
    }

    static private void logout() {
        driver.findElement(By.xpath("//ul[contains(concat(' ', @class, ' '), ' loginsignup ')]/li[last()]")).click();
        waitForRedirect.run();
    }
}