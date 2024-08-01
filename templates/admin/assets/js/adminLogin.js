const mostrarSenhaLogin=document.getElementById("mostrarSenhaLogin")
const entrarLogin=document.getElementById("entrarLogin")
const senhaLogin=document.getElementById("senhaLogin")

let sinalLogin=0

mostrarSenhaLogin.addEventListener("click", ()=>{
    if(sinalLogin==0){
        senhaLogin.type="text"
        sinalLogin=1
    }else{
        senhaLogin.type="password"
        sinalLogin=0
    }
})

