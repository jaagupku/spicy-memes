import org.junit.BeforeClass;
import org.openqa.selenium.By;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

public class FirefoxTests extends ChromeTests {
    @BeforeClass
    public static void before() throws InstantiationException, IllegalAccessException {
        initialize(FirefoxDriver.class, "gecko", () -> {
            // Wait until <html> is detached from DOM
            new WebDriverWait(driver, 5).until(ExpectedConditions.stalenessOf(driver.findElement(By.tagName("html"))));

            // Wait until <html> is attached again
            new WebDriverWait(driver, 5).until(ExpectedConditions.not(ExpectedConditions.stalenessOf(driver.findElement(By.tagName("html")))));

            // Wait until document.readyState == "complete"
            new WebDriverWait(driver, 5).until((driver) -> ((JavascriptExecutor) driver).executeScript("return document.readyState").equals("complete"));

            System.out.println("WAIT");
        });
    }
}