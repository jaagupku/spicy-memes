import org.junit.After;
import org.junit.Before;
import org.junit.Test;
import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.remote.RemoteWebDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

import java.util.List;

public class ChromeTests {
    RemoteWebDriver driver;

    @Before
    public void before() {
        System.setProperty("webdriver.chrome.driver", "./drivers/chromedriver.exe");

        driver = new ChromeDriver();
        driver.get("https://spicymemes.cs.ut.ee");

        login();
    }

    @After
    public void after() {
        logout();
        driver.quit();
    }

    @Test
    public void voteMeme() {
        WebElement memeContainer = driver.findElementsByClassName("meme-container").get(0);
        WebElement upvote = memeContainer.findElement(By.className("upvote"));
        WebElement downvote = memeContainer.findElement(By.className("downvote"));

        upvote.click();
        new WebDriverWait(driver, 10).until(ExpectedConditions.attributeContains(upvote, "class", "active"));

        downvote.click();
        new WebDriverWait(driver, 10).until(ExpectedConditions.not(ExpectedConditions.attributeContains(downvote, "class", "active")));

        downvote.click();
        new WebDriverWait(driver, 10).until(ExpectedConditions.not(ExpectedConditions.not(ExpectedConditions.attributeContains(downvote, "class", "active"))));
    }

    @Test
    public void writeAndVoteComment() {
        driver.findElementsByClassName("meme-container").get(0).findElement(By.tagName("a")).click();
        waitForRedirect();

        // Leave some comments
        for (int i = 0; i < 5; ++i) {
            driver.findElementById("comment").sendKeys("Autotest comment xD [" + (i + 1) + "]");
            driver.findElementById("submitComment").submit();
            waitForRedirect();
        }

        WebElement firstComment = driver.findElementByXPath("//a[contains(concat(' ', @class, ' '), 'user-comments')]/..");
        WebElement upvote = firstComment.findElement(By.className("upvote"));
        WebElement downvote = firstComment.findElement(By.className("downvote"));

        // Test (up|down)voting on the first comment
        upvote.click();
        new WebDriverWait(driver, 10).until(ExpectedConditions.attributeContains(upvote, "class", "active"));

        downvote.click();
        new WebDriverWait(driver, 10).until(ExpectedConditions.not(ExpectedConditions.attributeContains(downvote, "class", "active")));

        downvote.click();
        new WebDriverWait(driver, 10).until(ExpectedConditions.not(ExpectedConditions.not(ExpectedConditions.attributeContains(downvote, "class", "active"))));

        // Delete all comments left by user `autotest`
        while (true) {
            List<WebElement> autotestComments = driver.findElementsByXPath("//a[contains(concat(' ', @class, ' '), 'user-comments') and . = 'autotest']/..");

            if (autotestComments.size() == 0) {
                break;
            }

            autotestComments.get(0).findElement(By.id("deleteComment")).click();
            waitForRedirect();
        }
    }

    void waitForRedirect() {
    }

    void login() {
        driver.findElement(By.xpath("//ul[contains(concat(' ', @class, ' '), ' loginsignup ')]/li[1]")).click();
        new WebDriverWait(driver, 10).until(ExpectedConditions.visibilityOf(driver.findElement(By.id("signuploginmodal"))));

        driver.findElementByName("username").sendKeys("autotest");
        driver.findElementByName("password").sendKeys("autotest");
        driver.findElement(By.xpath("//button[contains(concat(' ', @class, ' '), ' btn-login ')]")).click();

        waitForRedirect();
    }

    private void logout() {
        driver.findElement(By.xpath("//ul[contains(concat(' ', @class, ' '), ' loginsignup ')]/li[last()]")).click();
        waitForRedirect();
    }
}