
let gallery = document.getElementById("gallery");

let list = gallery.getElementsByTagName("li");


document.querySelectorAll("li").forEach(node => {

    if(node.id != ""){

        //console.log(node.id);

        node.onclick = () => {
            node.firstChild.click();
            //console.log(node.firstChild);
        }
    }
});
