



function showmodel(){
    document.querySelector('.overlay').classList.add('showoverlay')
    document.querySelector('.login-box').classList.add('showlogin-box')
}
function showmodel2(){
    document.querySelector('.overlay2').classList.add('showoverlay2')
    document.querySelector('.registration-box').classList.add('showlregistration-box')
}
function closemodel(){
    document.querySelector('.overlay').classList.remove('showoverlay')
    document.querySelector('.login-box').classList.remove('showlogin-box')
}






//                 // another way to activate popup


// var btnlogin = document.querySelector(".login");
// btnlogin.addEventListener("click", showmodel)


// var c = document.querySelector(".close");
// c.addEventListener("click", closemodel)



//                       // js of registration popup


function showreg_model(){
    document.querySelector('.reg-overlay').classList.add('showreg-overlay')
    document.querySelector('.registration-box').classList.add('showregistration-box')
}
function showreg_model2(){
    document.querySelector('.reg-overlay').classList.add('showreg-overlay')
    document.querySelector('.registration-box').classList.add('showregistration-box')
}
function closereg_model(){
    document.querySelector('.reg-overlay').classList.remove('showreg-overlay')
    document.querySelector('.registration-box').classList.remove('showregistration-box')
}