var titles =document.querySelectorAll(".service_titale");
var sevice_description=document.querySelectorAll(".sevice_description");
var icons=document.querySelectorAll(".ri-add-fill");
var headings=document.querySelectorAll(".service_titale h2");

titles.forEach((title,index) => {
    title.addEventListener('click' , () => {
        var isActive = sevice_description[index].classList.contains('ActiveDesc');

        sevice_description.forEach((desc) =>{
            desc.classList.remove('ActiveDesc');
        });
        icons.forEach((icon) =>{
            icon.classList.remove('ri-subtract-line');
        });
        headings.forEach((heading) =>{
            heading.classList.remove('ActiveHeading');
        });

        if(!isActive){
            sevice_description[index].classList.add('ActiveDesc');
            icons[index].classList.toggle('ri-subtract-line');
            headings[index].classList.toggle('ActiveHeading');
        }
    });
});