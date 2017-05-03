import org.junit.After;
import org.junit.Before;
import org.junit.Test;
import org.openqa.selenium.By;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.remote.RemoteWebDriver;

import static org.junit.Assert.assertEquals;

public class ChromeTests {
    RemoteWebDriver driver;

    @Before
    public void before() {
        System.setProperty("webdriver.chrome.driver", "./drivers/chromedriver.exe");

        driver = new ChromeDriver();
        driver.get("https://spicymemes.cs.ut.ee");
    }

    @After
    public void after() {
        driver.quit();
    }

    @Test
    public void navigateAll() {
        assertEquals("Hot - Spicy Memes", driver.getTitle());

        driver.findElement(By.className("top")).click();
        waitForRedirect();
        assertEquals("Top - Spicy Memes", driver.getTitle());

        driver.findElement(By.className("new")).click();
        waitForRedirect();
        assertEquals("New - Spicy Memes", driver.getTitle());

        driver.findElement(By.className("hot")).click();
        waitForRedirect();
        assertEquals("Hot - Spicy Memes", driver.getTitle());
    }

    public void waitForRedirect() {
    }
}