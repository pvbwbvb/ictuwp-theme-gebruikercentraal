function hideMenuButton(e,t,n){header.classList.remove("menu-met-js"),thecontent.classList.remove("menuopen"),header.classList.add("geen-menu-button");var u=e.getElementById("menu-button");u&&(headerwrap.removeChild(u),console.log("burp"))}function showMenuButton(e,t,n){"use strict";header.classList.add("menu-met-js"),menu.setAttribute("aria-hidden","true"),menu.setAttribute("aria-labelledby","menu-button"),header.classList.remove("geen-menu-button"),console.log("create the button"),(menuButton=e.createElement("button")).classList.add("menu-button"),menuButton.setAttribute("id","menu-button"),menuButton.setAttribute("aria-label","Menu"),menuButton.setAttribute("aria-expanded","false"),menuButton.setAttribute("aria-controls","menu"),menuButton.innerHTML="<i>&#x2261;</i><b>&nbsp;menu</b>",headerwrap.appendChild(menuButton);var u=function(e){27===e.which&&(e.stopPropagation(),e.preventDefault(),menu.classList.contains("active")&&a())},a=function(e){menu.classList.contains("active")?(header.classList.remove("active"),thecontent.classList.remove("menuopen"),menu.classList.remove("active"),menu.setAttribute("aria-hidden","true"),menuButton.setAttribute("aria-expanded","false"),menuButton.innerHTML="<i>&#x2261;</i><b>&nbsp;menu</b>"):(header.classList.add("active"),thecontent.classList.add("menuopen"),menu.classList.add("active"),menu.setAttribute("aria-hidden","false"),menuButton.setAttribute("aria-expanded","true"),menuButton.innerHTML="<i>&times;</i><b>&nbsp;menu</b>")};menuButton.addEventListener("click",function(){a()},!1),menuButton.addEventListener("keydown",function(e){u(e)})}function WidthChange(e){e.matches?hideMenuButton(document,window):showMenuButton(document,window)}var header=document.querySelector(".site-header"),headerwrap=document.querySelector(".site-header .wrap"),menu=document.querySelector(".nav-primary"),searchform=document.querySelector(".nav-primary"),thecontent=document.querySelector("#maincontent"),menuButton=document.querySelector("button.menu-button"),menuButton;if(matchMedia){var mq=window.matchMedia("(min-width: 830px)");mq.addListener(WidthChange),WidthChange(mq)}