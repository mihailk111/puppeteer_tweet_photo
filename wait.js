
function wait(seconds)
{
    seconds *= 1000;
    return new Promise((resolve)=>{
        setTimeout(() => {
           resolve(); 
        }, seconds);
    })
}

exports.wait = wait;