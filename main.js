
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
<<<<<<< HEAD


=======
>>>>>>> 1072e2896492a9cb4b2b6f8dabd25382ad83c585
