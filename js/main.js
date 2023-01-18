function call_js(){
  //화면객체참조변수지정
  let slideshow = document.querySelector('.slideshow');
  let slideshowSlides = document.querySelector('.slideshow_slides');
  let slides = document.querySelectorAll('.slideshow_slides a');
  let prev = document.querySelector('.prev');
  let next = document.querySelector('.next');
  let indicators = document.querySelectorAll('.indicator a');
  let currentIndex = 0; 
  let timer ="";
  let slideCount = slides.length; 

  for(let i=0; i < slides.length; i++ ){
    let newLeft = i*100+'%';
    slides[i].style.left = newLeft;
  }

  function gotoSlide(index){
    currentIndex = index;
    let newLeft = index * -100 + '%';
    slideshowSlides.style.left = newLeft;
    indicators.forEach((obj)=>{
      obj.classList.remove('active'); 
    }); 
    indicators[index].classList.add('active');
  }

  gotoSlide(0);

  //3초마다 함수를 부른다.
  function startTimer(){
    timer = setInterval(function(){
      let nextIndex = (currentIndex + 1) % slideCount;
      gotoSlide(nextIndex);
    }, 3000)
  }
  startTimer(); 

  // 마우스포인터 slideshowSlides 들어오면 타이머를 멈춘다. 
  slideshowSlides.addEventListener('mouseenter',()=>{
    clearInterval(timer);
  })
  slideshowSlides.addEventListener('mouseleave',function(){
    startTimer(); 
  })
  prev.addEventListener('mouseenter',()=>{
    clearInterval(timer);
  })
  next.addEventListener('mouseenter',()=>{
    clearInterval(timer);
  })
  //prev , next 이벤트설정
  prev.addEventListener('click',(e)=>{
    e.preventDefault(); //a tag 가지고 기본기능 막는다.
    currentIndex = currentIndex -1; 
    if(currentIndex < 0){
      currentIndex = 3;
    }
    gotoSlide(currentIndex);
  });

  next.addEventListener('click',(e)=>{
    e.preventDefault(); //a tag 가지고 기본기능 막는다.
    currentIndex = currentIndex + 1; 
    if(currentIndex > 3){
      currentIndex = 0;
    }
    gotoSlide(currentIndex);
  });

  //indicator click 해당화면으로이동
  indicators.forEach((obj)=>{
    obj.addEventListener('mouseenter',()=>{
      clearInterval(timer);
    });
  }); 

  for(let i=0; i<indicators.length; i++){
    indicators[i].addEventListener('click',(e)=>{
      e.preventDefault(); 
      gotoSlide(i);
    });
  }

}