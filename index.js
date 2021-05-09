const puppeteer = require("puppeteer");
const waitJs = require("./waitJs.js").waitJs;
const wait = require("./wait.js").wait;
const log = console.log;

const urls = [  
                "https://twitter.com/RussianStandup",
                "https://twitter.com/RussianStandup/status/1371736631493980172",
                "https://twitter.com/Deni20893267/status/1371913663636983810",
                "https://twitter.com/RussianStandup/status/1379112039138918417",
                "https://vk.com/nokita"
            ];

async function main(){
    const browser = await puppeteer.launch({headless:false, defaultViewport:{width: 1280, height:1024}, product: "firefox" });
    const page = await browser.newPage();

    for(let i =0; i< urls.length; i++){

        const url = urls[i];

        await page.goto(url, {timeout: 0 , waitUntil: "load" });

        await waitJs(page); //TODO DID THIS HELP ? 
        await wait(30);  

       await page.screenshot({ path: "./pictures/"+url.replace(/\W/g, "_")+".png" });
    //    await page.pdf({printBackground: true, path: "./pdf/"+url.replace(/\W/g, "_")+".pdf" });

    }


    await browser.close();

    log("DONE !");
}

main();


/*
    for (let index = 0; index < 10000; index++) {
        await wait(30);
        await page.screenshot({ path: "./pictures/"+url.replace(/\W/g, "_")+index+".png" });
        await page.mouse.wheel({deltaY: 200});
    }  
*/









