
refTitreStyles=document.querySelector(".titreSecondaireBis");
refListeStyle=document.querySelector(".listeStyle");

function montrerStyles(){
    refListeStyle.classList.toggle('style--closed');
    console.log(refListeStyle.className)
    console.log(refTitreStyles.className==="style--closed")

    for(let intCpt=0; intCpt<refTitreStyles.classList.length; intCpt++){
        if(refTitreStyles.classList[intCpt]==="style--closed"){
            refTitreStyles.classList.remove("style--closed");
        } else{
            refTitreStyles.classList.add("style--closed");
        }
    }

}

document.querySelector(".titreSecondaireBis").addEventListener("click", function(){
    montrerStyles();
})