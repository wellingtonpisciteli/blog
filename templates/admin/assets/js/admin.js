const abrirMenu=document.getElementById("abrirMenu")
const abrirMenu2=document.getElementById("abrirMenu2")
const menu=document.getElementById("menu")
const menu2=document.getElementById("menu2")
const nomeUsuario=document.getElementById("nomeUsuario")
const container=document.getElementById("container")
const menuFechado=document.getElementById("menuFechado")
const h2Elements=document.querySelectorAll('.menuFechado h2');
const topo=document.getElementById("topo")
const rodape=document.getElementById("rodape")
const opcoes=document.getElementById("opcoes")
const titulo=document.getElementById("titulo")
const texto=document.getElementById("texto")
const btnCadastrar=document.getElementById("btnCadastrar")

let sinal=0
let sinal2=0
let sinal3=0

abrirMenu.addEventListener("click", ()=>{
    if(sinal==1){
        sinal=0
        menu.style.display="flex"
        menuFechado.style.display="none"
        topo.style.left="19.7%"
        topo.style.width="80.2%"
        container.style.width="80.2%"
        rodape.style.width="80.2%"
    }else{
        sinal=1
        menu.style.display="none"
        menuFechado.style.display="flex"
        topo.style.left="5%"
        topo.style.width="95%"
        container.style.width="95%"
        rodape.style.width="95%"
    }
})

abrirMenu2.addEventListener("click", ()=>{
    if(sinal2==1){
        sinal2=0
        menu2.style.display="none"
    }else{
        sinal2=1
        menu2.style.display="flex"
    }
})

nomeUsuario.addEventListener("click", ()=>{
    if(sinal3==0){
        sinal3=1
        opcoes.style.display="flex"
        nomeUsuario.style.border="1px solid black"
    }else{
        sinal3=0
        opcoes.style.display="none"
        nomeUsuario.style.border="0px"
    }
})

container.addEventListener("click", ()=>{
    if(sinal3==1)
        sinal3=0
        opcoes.style.display="none"
        nomeUsuario.style.border="0px"
})


h2Elements.forEach(h2=>{
    const tooltip=h2.querySelector('.tooltip')
    h2.addEventListener('mouseover', ()=>{
        tooltip.style.visibility='visible'
        tooltip.style.opacity='1'
    })
    h2.addEventListener('mouseout', ()=>{
        tooltip.style.visibility='hidden'
        tooltip.style.opacity='0'
    })
})

btnCadastrar.addEventListener("click", ()=>{
    if(titulo.value=="" || texto.value==""){
        alert("Preencha todos os campos!")
    }
})

    







