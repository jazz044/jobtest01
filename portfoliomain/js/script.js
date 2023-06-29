document.addEventListener('DOMContentLoaded', function() {
    let nav = document.getElementById('nav_box');
    let burger = document.getElementById('burger');
    let body = document.getElementById('body');
    burger.addEventListener('click', function() {
        burger.classList.toggle('open');
        body.classList.toggle('lock');
        nav.classList.toggle('active');
    });
});

$(document).ready(function(){
    $("#nav_box").on("click","a", function (event) {
        event.preventDefault();
        var id  = $(this).attr('href'),
            top = $(id).offset().top;
        $('body,html').animate({scrollTop: top}, 1500);
    });
});

let mask = document.querySelector('.mask');

window.addEventListener('load', () => {
  mask.classList.add('hide');
  setTimeout(() =>{
    mask.remove();
   }, 2000 );
});