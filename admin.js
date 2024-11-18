const menu1 = document.getElementById('przycisk1')
const menu2 = document.getElementById('przycisk2')

menu1.addEventListener("click", function()
{
    document.getElementById('pole1').style.visibility='visible'
    document.getElementById('pole2').style.visibility='hidden'
    document.getElementById('przycisk1').style.borderBottom='3.3px solid rgba(43, 255, 0, 1)'
    document.getElementById('przycisk2').style.borderBottom='none'
    document.getElementById('sciana1').style.height='70px'
    document.getElementById('sciana2').style.height='106px'
    document.getElementById('sciana1').style.bottom='19px'
    document.getElementById('sciana2').style.bottom='38px'
})
menu2.addEventListener("click", function()
{
    document.getElementById('pole2').style.visibility='visible'
    document.getElementById('pole1').style.visibility='hidden'
    document.getElementById('przycisk2').style.borderBottom='3.3px solid rgba(43, 255, 0, 1)'
    document.getElementById('przycisk1').style.borderBottom='none'
    document.getElementById('sciana1').style.height='106px'
    document.getElementById('sciana2').style.height='70px'
    document.getElementById('sciana1').style.bottom='38px'
    document.getElementById('sciana2').style.bottom='19px'

    
})