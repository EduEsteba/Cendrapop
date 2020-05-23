package com.selenium;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.firefox.FirefoxDriver;
import java.util.concurrent.TimeUnit;

public class Main {

    public static void main(String[] args) throws InterruptedException {
        //Cambia la ruta del teu directori perque funcioni//
        System.setProperty("webdriver.gecko.driver","C:\\Users\\Eduard\\Desktop\\geckodriver.exe");

        //Test login
        WebDriver driver = new FirefoxDriver();
        driver.get("http://127.0.0.1:8000/login");
        driver.manage().window().maximize();
        driver.findElement(By.id("email")).sendKeys("jotape@jotape.com");
        driver.findElement(By.id("password")).sendKeys("1234567890");
        driver.manage().timeouts().implicitlyWait(60, TimeUnit.SECONDS);
        driver.findElement(By.id("login")).click();
        Thread.sleep(3000);

        //Test nova categoria
        driver.findElement(By.id("novacategoria")).click();
        driver.findElement(By.id("novacategoria2")).click();
        driver.findElement(By.id("title")).sendKeys("Categoria Selenium");
        driver.manage().timeouts().implicitlyWait(60, TimeUnit.SECONDS);
        driver.findElement(By.id("enviar")).click();
        Thread.sleep(3000);

        //Buscar un usuari
        driver.findElement(By.id("buscarusuaris")).click();
        driver.findElement(By.id("search")).sendKeys("eduard");
        driver.manage().timeouts().implicitlyWait(60, TimeUnit.SECONDS);

















    }
}
