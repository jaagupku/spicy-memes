import org.junit.After;
import org.junit.Before;
import org.junit.Test;
import org.openqa.selenium.By;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;

import static org.junit.Assert.*;

public class ChromeTests {
    WebDriver driver;

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
        assertEquals("Top - Spicy Memes", driver.getTitle());

        driver.findElement(By.className("new")).click();
        assertEquals("New - Spicy Memes", driver.getTitle());

        driver.findElement(By.className("hot")).click();
        assertEquals("Hot - Spicy Memes", driver.getTitle());
    }
}