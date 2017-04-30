import org.openqa.selenium.By;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

public class FirefoxTests extends ChromeTests {
    @Override
    public void before() {
        System.setProperty("webdriver.gecko.driver", "./drivers/geckodriver.exe");

        driver = new FirefoxDriver();
        driver.get("https://spicymemes.cs.ut.ee");
    }

    @Override
    public void waitForRedirect() {
        // Wait until <html> is detached from DOM
        new WebDriverWait(driver, 5).until(ExpectedConditions.stalenessOf(driver.findElement(By.tagName("html"))));

        // Wait until <html> is attached again
        new WebDriverWait(driver, 5).until(ExpectedConditions.not(ExpectedConditions.stalenessOf(driver.findElement(By.tagName("html")))));

        // Wait until document.readyState == "complete"
        new WebDriverWait(driver, 5).until((driver) -> ((JavascriptExecutor) driver).executeScript("return document.readyState").equals("complete"));
    }
}
