
function wait(seconds)
{
    return new Promise((resolve)=>{
        setTimeout(() => {
           resolve(); 
        }, seconds);
    })
}


async function main(){

    await wait(3000);

    console.log("three");

    await wait(5000);

    console.log("five");
}


main()

console.log("start");