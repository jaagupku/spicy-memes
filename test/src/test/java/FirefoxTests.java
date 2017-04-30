import org.openqa.selenium.firefox.FirefoxDriver;

public class FirefoxTests extends ChromeTests {
    @Override
    public void before() {
        System.setProperty("webdriver.gecko.driver", "./drivers/geckodriver.exe");

        // TODO: Firefox'i draiver ei oota lehe laadimise lõppu kui klikkitakse 'a' elemendile

        driver = new FirefoxDriver();
        driver.get("https://spicymemes.cs.ut.ee");
    }
}
