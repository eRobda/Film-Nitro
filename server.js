const express = require('express');
const { Builder, By, Capabilities, Key, until, Options } = require('selenium-webdriver');
const chrome = require('selenium-webdriver/chrome');
const cors = require('cors');

const hostname = 'localhost';
const port = 8080;

let odkaz = "";
let nalezeno = false;

const app = express();
app.use(cors());

app.get('/', async (req, res) => {
  // Extract the 'arg' parameter from the query string
  const query = req.query.arg;

  if(query){
    console.log(Cas() + ' Hledám film: ' + query);

    var options = new chrome.Options();
    options.addArguments("--headless");
    //uprava zde, v případě chyby smazat!
    options.excludeSwitches('enable-logging');
    
    let driver = await new Builder()
      .forBrowser('chrome')
      .setChromeOptions(options)
      .build();
    try {
      //dalsi uprava zde. Original: await driver.get('https://prehrajto.cz/);
      await driver.get('https://prehrajto.cz/hledej/' + String(query));
      //await driver.findElement(By.id('search-phrase')).sendKeys(String(query), Key.RETURN);


      const elements = await driver.findElements(By.className('column'));

      if(elements.length > 3){
        nalezeno = true;
        console.log(Cas() + ' Film ' + query + ' nalezen');
      }
      else{
        nalezeno = false;
        console.log(Cas() + ' Film ' + query + ' nenalezen');
      }

      if(nalezeno){
        const element = await driver.findElement(By.className('column'));
        await element.click();
        odkaz = await driver.findElement(By.className('jw-video')).getAttribute('src');
      }
    }
    finally {
      await driver.quit();
    }
  }

  // Send the response
  res.statusCode = 200;
  res.setHeader('Content-Type', 'text/plain');
  if(nalezeno){
    res.end(odkaz);
  }else{
    res.end('nenalezeno');
  }
});

const server = app.listen(port, hostname, () => {
  console.log(Cas() + ` Server běží na: ${hostname}:${port}/`);
});

function Cas(){
  var currentdate = new Date(); 
  var datetime =    currentdate.getDate() + "/"
                  + (currentdate.getMonth()+1)  + "/" 
                  + currentdate.getFullYear() + " "  
                  + currentdate.getHours() + ":"  
                  + currentdate.getMinutes() + ":" 
                  + currentdate.getSeconds();
  return datetime;
}
