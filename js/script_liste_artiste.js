refButtonPlus=document.querySelector(".plus");
refButtonSavoirPlus=document.querySelector(".enSavoirPlus");

document.querySelector(".infoArtiste__img").addEventListener("mouseover", function(){
    refButtonPlus.removeAttribute("hidden");
})

document.querySelector(".infoArtiste__img").addEventListener("mouseout", function(){
    refButtonPlus.setAttribute("hidden", "hidden");
})

document.querySelector(".plus").addEventListener("mouseover", function(){
    refButtonSavoirPlus.removeAttribute("hidden");
})
document.querySelector(".plus").addEventListener("mouseout", function(){
    refButtonSavoirPlus.setAttribute("hidden", "hidden");
})