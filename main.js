// registration number: 1906423

let body = document.getElementById("body")
let gallery = document.getElementById("gallery");

let list = gallery.getElementsByTagName("li");


document.querySelectorAll("li").forEach(node => {

    if(node.id != ""){


        node.onclick = () => {
            node.firstChild.click();
            //console.log(node.firstChild);
        }
    }
});


let currentMarginTop = 0;
window.onbeforeunload = e => {
    body.style.margin = "0";
    return; // stops the pop-up that asks if you want to leave the page
}
body.style.margin = "0";
window.addEventListener("wheel", e => {

    document.querySelectorAll("li").forEach(node => {
            node.classList.add("notransition")
        })
    if(e.deltaY < 0){
        currentMarginTop += -80;

    }else if(
        e.deltaY >= 0 && 
        currentMarginTop < (body.scrollHeight) - window.innerHeight
    ){
        currentMarginTop += 80;
    }

    if(currentMarginTop < 0){currentMarginTop = 0}
    
    body.style.cssText = "margin-top:-"+ currentMarginTop +"px;";

    setTimeout(function() { 
        document.querySelectorAll("li").forEach(node => {
        node.classList.remove("notransition")})
    }, 50);
   
})

