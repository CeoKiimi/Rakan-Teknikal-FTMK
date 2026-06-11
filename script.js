const approve=document.querySelectorAll(".green");

approve.forEach(btn=>{

btn.onclick=function(){

return confirm("Approve this application?");

}

});

const reject=document.querySelectorAll(".red");

reject.forEach(btn=>{

btn.onclick=function(){

return confirm("Reject this application?");

}

});