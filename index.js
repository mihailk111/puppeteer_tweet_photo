const puppeteer = require("puppeteer");
const wait = require("./wait.js").wait;
const log = console.log;
const urls = [  
                "https://twitter.com/RussianStandup/status/1371736631493980172",
                //"https://twitter.com/Deni20893267/status/1371913663636983810",
                //"https://twitter.com/RussianStandup/status/1379112039138918417"
            ];

async function main(){
    const browser = await puppeteer.launch({defaultViewport:{width: 900, height:1300} });
    const page = await browser.newPage();

    for(let i =0; i< urls.length; i++){

        const url = urls[i];

        await page.goto(url, {timeout: 0 , waitUntil: "domcontentloaded" });
        
        let sec = 60;
        log(`waiting ${sec} sec`);
        await wait(sec);

        await page.screenshot({ path: "./pictures/"+url.replace(/\W/g, "_")+".png" });

    }


/*
    for (let index = 0; index < 10000; index++) {

        await wait(30);
        await page.screenshot({ path: "./pictures/"+url.replace(/\W/g, "_")+index+".png" });
        await page.mouse.wheel({deltaY: 200});

    }  
*/
    await browser.close();
    log("DONE !");
}


main();
