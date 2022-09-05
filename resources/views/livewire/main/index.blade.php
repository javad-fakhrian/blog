@section('head')

  <style>
    .text-glow-xl {
      text-shadow: 0 0 5px rgb(255 255 255 / 80%), 0 0 20px rgb(255 255 255 / 29%);
    }
  </style>

  <style>
    .marquee {
      animation: scrolling var(--marquee-time) linear infinite;
    }

    .marquee:hover {
      animation-play-state: paused;
    }

    @keyframes scrolling {
      0% { transform: translateX(0); }
      100% { transform: translateX(calc(-1 * var(--marquee-width))); }
    }
  </style>

  <style>
    [x-cloak] { display: none; }

    .progress {
      animation:progress;
      animation-iteration-count:1;
      animation-fill-mode:forwards;
      animation-timing-function:linear;
    }
    @keyframes progress {
      0% {
        width: 0%;
      }
      80% {
        opacity: 1;
      }
      100% {
        opacity: 0.5;
        width: 100%;
      }
    }
  </style>

  <script>     
    function app() {
      return {
          turns: 0,
          won: false,
          winSeq: ['012','345','678','036','147','258','048','246'],
          grid: Array.apply(null, Array(9)).map(function (v,i) { return null}),
          xChars: ['x','X'],
          oChars: ['o','O'],
          xTurns: '',
          oTurns: '',
          select: function(index) {
              if(this.won || this.grid[index] !== null || this.turns>=9) return;
              this.turns++;
              if( this.turns % 2 == 0 ) {
                  this.grid[index] = this.xChars[Math.floor(Math.random() * this.xChars.length)];
                  this.xTurns += index;
              } else {
                  this.grid[index] = this.oChars[Math.floor(Math.random() * this.oChars.length)];
                  this.oTurns += index;
              }
              this.checkWinner();
          },
          checkWinner: function() {
              for(let i = 0, length = this.winSeq.length; i < length; i++){
                  if( new RegExp(`[${this.winSeq[i]}]{3}`).test(this.xTurns.replace(new RegExp(`[^${this.winSeq[i]}]+`,'g'),'')) ) {
                      this.won = 'X';
                      break;
                  } else if( new RegExp(`[${this.winSeq[i]}]{3}`).test(this.oTurns.replace(new RegExp(`[^${this.winSeq[i]}]+`,'g'),'')) ) {
                      this.won = 'O';
                      break;
                  }
              }
              return this.won;
          },
          reset: function() {
              this.turns = 0;
              this.won = false;
              this.grid = Array.apply(null, Array(9)).map(function (v,i) { return null});
              this.xTurns = '';
              this.oTurns = '';
          }
      }
    }
  </script>

  <script>

    const debounce = (func, wait, immediate = true) => {
      let timeout
      return () => {
        const context = this
        const args = arguments
        const callNow = immediate && !timeout
        clearTimeout(timeout)
        timeout = setTimeout(function () {
          timeout = null
          if (!immediate) {
            func.apply(context, args)
          }
        }, wait)
        if (callNow) func.apply(context, args)
      }
    }

    const appendChildAwaitLayout = (parent, element) => {
      return new Promise((resolve, _) => {
        const resizeObserver = new ResizeObserver((entries, observer) => {
          observer.disconnect()
          resolve(entries)
        })
        resizeObserver.observe(element)
        parent.appendChild(element)
      })
    }

    document.addEventListener('alpine:init', () => {
      Alpine.data(
        'Marquee',
        ({ speed = 1, spaceX = 0, dynamicWidthElements = false }) => ({
          dynamicWidthElements,
          async init() {
            if (this.dynamicWidthElements) {
              const images = this.$el.querySelectorAll('img')
              
              if (images) {
                await Promise.all(
                  Array.from(images).map(image => {
                    return new Promise((resolve, _) => {
                      if (image.complete) {
                        console.log(image.complete)
                        resolve()
                      } else {
                        image.addEventListener('load', () => {
                          resolve()
                        })
                      }
                    })
                  })
                )
              }
            }
            
            
            this.originalElement = this.$el.cloneNode(true)
            const originalWidth = this.$el.scrollWidth + spaceX * 4 
            this.$el.style.setProperty('--marquee-width', originalWidth + 'px')
            this.$el.style.setProperty(
              '--marquee-time',
              ((1 / speed) * originalWidth) / 100 + 's'
            )
            this.resize()
            window.addEventListener('resize', debounce(this.resize.bind(this), 100))
          },
          async resize() {
            
            this.$el.innerHTML = this.originalElement.innerHTML

            
            let i = 0
            while (this.$el.scrollWidth <= this.$el.clientWidth) {
              if (this.dynamicWidthElements) {
               
                await appendChildAwaitLayout(
                  this.$el,
                  this.originalElement.children[i].cloneNode(true)
                )
              } else {
                this.$el.appendChild(
                  this.originalElement.children[i].cloneNode(true)
                )
              }
              i += 1
              i = i % this.originalElement.childElementCount
            }

            
            let j = 0
            while (j < this.originalElement.childElementCount) {
              this.$el.appendChild(this.originalElement.children[i].cloneNode(true))
              j += 1
              i += 1
              i = i % this.originalElement.childElementCount
            }
          },
        })
      )
    })

    Alpine.start()
  </script>

  <script>
    window.testimonialSlideshow = function(slides) {
      return {
        title: 'نظر گیمرا',
        state: {
          moving: false,
          currentSlide: 0,
          looping: false,
          order: [],
          nextSlideDirection: '',
          userInteracted: false,
          usedKeyboard: false,
        },
        autoplayTimer: null,
        attributes: {
          direction: 'right-left',
          duration: 1000,
          timer: 7000,
        },
        slides: [],
        setup() {
          this.slides = slides.map((slide, index) => { slide.id = index + Date.now(); return slide })
            
          // Cache the original order so that we can reorder on transition (to skip inbetween slides)
          this.state.order = this.slides.map(slide => slide.id)
          const newSlideOrder = this.slides.filter(slide => this.current.id != slide.id)
          newSlideOrder.unshift(this.current)
          this.slides = newSlideOrder
            
          // Start the autoslide
          this.attributes.timer && this.autoPlay()
        },
        get current() {
          return this.slides.find(slide => slide.id == this.state.order[this.state.currentSlide])
        },
        get previousSlide() {
          return (this.state.currentSlide - 1) > -1 ? this.state.currentSlide - 1 : this.state.currentSlide
        },
        get nextSlide() {
          return (this.state.currentSlide + 1) < this.slides.length ? this.state.currentSlide + 1 : this.state.currentSlide
        },
        updateCurrent(nextSlide) {
          if (nextSlide == this.state.currentSlide) return
          if (this.state.moving) return
          this.state.moving = true

          const next = this.slides.find(slide => slide.id == this.state.order[nextSlide])

          // Reorder the slides for a smoother transition
          const newSlideOrder = this.slides.filter(slide => {
            return ![this.current.id, this.state.order[nextSlide]].includes(slide.id)
          })

          const activeSlides = [this.current, next]
          this.state.nextSlideDirection = nextSlide > this.state.currentSlide ? 'right-to-left' : 'left-to-right'

          newSlideOrder.unshift(...(this.state.nextSlideDirection == 'right-to-left' ? activeSlides : activeSlides.reverse()))
          this.slides = newSlideOrder
          this.state.currentSlide = nextSlide
          setTimeout(() => {
            this.state.moving = false
            // TODO: possibly a better check to determine whether autoplay should resume
            this.attributes.timer && !this.autoplayTimer && this.autoPlay()
          }, this.attributes.duration)

        },
        transitions(state, $dispatch) {
          const rightToLeft = this.state.nextSlideDirection === 'right-to-left'
          switch (state) {
            case 'enter':
              return `transition-all duration-${this.attributes.duration}`
            case 'enter-start':
              return rightToLeft ? 'transform translate-x-full' : 'transform -translate-x-full'
            case 'enter-end':
              return 'transform translate-x-0'
            case 'leave':
              return `absolute top-0 transition-all duration-${this.attributes.duration}`
            case 'leave-start':
              return 'transform translate-x-0'
            case 'leave-end':
              return rightToLeft ? 'transform -translate-x-full' : 'transform translate-x-full'
          }
        },
        autoPlay() {
          this.loop = () => {
            const next = (this.state.currentSlide === (this.slides.length - 1)) ? 0 : this.state.currentSlide + 1
            this.updateCurrent(this.state.looping ? next : this.currentSlide)
            this.autoplayTimer = setTimeout(() => {
              requestAnimationFrame(this.loop)
            }, this.attributes.timer + this.attributes.duration)
            
          }
          this.autoplayTimer = setTimeout(() => {
            this.state.looping = true
            requestAnimationFrame(this.loop)
          }, this.attributes.timer)
        },
        stopAutoplay() {
          clearTimeout(this.autoplayTimer)
          this.autoplayTimer = null
        }
      }
    }

    window.slides = [
      {
        content: 'آیا تا بحال دیوانگی رو برات تعریف کردم؟',
        author: 'FarCry 3'
      },
      {
        content: 'زنده ماندم، چون شعله آتش درونم بسیار بزرگتر از آتش اطرافم بود.',
        author: 'Fallout: New Vegas'
      },
      {
        content: 'فرد مناسب در مکان نامناسب می‌تواند تغییرات دنیا را رقم بزند. پس بیدار شو آقای فریمن، بیدار شو و طعم دنیا را بچش.',
        author: 'Half-Life 2'
      },
      {
        content: 'به سلاح احتیاجی ندارم. قدرت من دوستانم هستند!',
        author: 'Kingdom Hearts'
      },
      {
        content: 'فداکاری انتخابی است که آن را انجام می‌دهید اما از دست دادن انتخابی است که برای شما ساخته شده.',
        author: 'Tomb Raider'
      },
      {
        content: 'تنها رفتن خطرناک است! این [شمشیر رو] بگیر.',
        author: 'The Legend Of Zelda'
      },
    ]
  </script>







@endsection

@section('title', 'صفحه اصلی')

<div >
    <div class="hero min-h-screen bg-base-200">
        <div class="hero-content flex-col lg:flex-row-reverse">
          <img src="/images/ax1.jpg" class="max-w-sm rounded-lg shadow-2xl" />
          <div>
            <h1 class="text-5xl font-bold">بازی ؟</h1>
            <p class="py-6">اگه شناختی  از بازیا نداری پس اشتباه نیومدی :)</p>
            <a href="#tic-tac-toe" class="btn btn-primary">تیک تاک تو</a>
          </div>
        </div>
    </div>

    <div class="min-w-screen min-h-screen  flex items-center justify-center px-5 py-5" id="tic-tac-toe">
      <div class="w-96 h-96 mx-auto text-indigo-500 rounded-md flex flex-wrap relative" x-data="app()">
        <p class="text-center flex justify-center items-center mb-10">بازی کن ببینم بلدی یا ن  ;)</p>
          <div class="flex w-full h-1/3">
              <template x-for="(item,index) in grid.slice(0,3)">
                  <div class="border-b border-gray-700 w-1/3" :class="{'border-r':index>0}">
                      <button class="w-full h-full outline-none focus:outline-none text-8xl leading-none" @click.prevent="select(index)">
                          <span x-show="item!==null" x-text="item" style="display:none;" class="inline-block" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-50" x-transition:enter-end="opacity-100 transform scale-100"></span>
                      </button>
                  </div>
              </template>
          </div>
          <div class="flex w-full h-1/3">
              <template x-for="(item,index) in grid.slice(3,6)">
                  <div class="border-b border-gray-700 w-1/3" :class="{'border-r':index>0}">
                      <button class="w-full h-full outline-none focus:outline-none text-8xl leading-none" @click.prevent="select(index+3)">
                          <span x-show="item!==null" x-text="item" style="display:none;" class="inline-block" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-50" x-transition:enter-end="opacity-100 transform scale-100"></span>
                      </button>
                  </div>
              </template>
          </div>
          <div class="flex w-full h-1/3">
              <template x-for="(item,index) in grid.slice(6,9)">
                  <div class="border-gray-700 w-1/3" :class="{'border-r':index>0}">
                      <button class="w-full h-full outline-none focus:outline-none text-8xl leading-none" @click.prevent="select(index+6)">
                          <span x-show="item!==null" x-text="item" style="display:none;" class="inline-block" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-50" x-transition:enter-end="opacity-100 transform scale-100"></span>
                      </button>
                  </div>
              </template>
          </div>
          <button class="absolute top-0 left-0 w-96 h-96 flex items-center justify-center outline-none focus:outline-none" style="display:none;" x-show="won||turns>=9" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-50 rotate-12" x-transition:enter-end="opacity-100 transform scale-100 rotate-0" @click.prevent="reset()">
              <span class="block transform -rotate-12 text-white text-9xl text-glow-xl" x-text="won?'بردی !':'😔'"></span>
          </button>
      </div>
    </div>

    <div class="overflow-hidden mx-auto py-2 mt-24 mb-24 ">
      <ul class="marquee py-3 inline-flex space-x-24 max-w-full items-center flex-row-reverse" x-data="Marquee({speed: 1, spaceX: 4, dynamicWidthElements: true})">
        <li class="flex-shrink-0">
          <img src="/images/ax1.jpg" class="max-h-40 w-auto rounded-lg shadow-xl">
        </li>
        <li class="flex-shrink-0">
          <img src="/images/a2.jpg" class="max-h-40 w-auto rounded-lg shadow-xl">
        </li>
        <li class="flex-shrink-0">
          <img src="/images/aa1.png" class="max-h-40 w-auto rounded-lg shadow-xl">
        </li>
        <li class="flex-shrink-0">
          <img src="/images/c5.gif" class="max-h-40 w-auto rounded-lg shadow-xl">
        </li>
        <li class="flex-shrink-0">
          <img src="/images/c6.gif" class="max-h-40 w-auto rounded-lg shadow-xl">
        </li>
        <li class="flex-shrink-0">
          <img src="/images/f1.jpg" class="max-h-40 w-auto rounded-lg shadow-xl">
        </li>
        <li class="flex-shrink-0">
          <img src="/images/st5.jpg" class="max-h-40 w-auto rounded-lg shadow-xl">
        </li>
        <li class="flex-shrink-0">
          <img src="/images/v5.gif" class="max-h-40 w-auto rounded-lg shadow-xl">
        </li>
        <li class="flex-shrink-0">
          <img src="/images/ac3.jpg" class="max-h-40 w-auto rounded-lg shadow-xl">
        </li>
        <li class="flex-shrink-0">
          <img src="/images/n5.jpg" class="max-h-40 w-auto rounded-lg shadow-xl">
        </li>
        <li class="flex-shrink-0">
          <img src="/images/v7.gif" class="max-h-40 w-auto rounded-lg shadow-xl">
        </li>
        <li class="flex-shrink-0">
          <img src="/images/p3.jpg" class="max-h-40 w-auto rounded-lg shadow-xl">
        </li>
        <li class="flex-shrink-0">
          <img src="/images/p9.jpg" class="max-h-40 w-auto rounded-lg shadow-xl">
        </li>
        <li class="flex-shrink-0">
          <img src="/images/ST7.jpg" class="max-h-40 w-auto rounded-lg shadow-xl">
        </li>
        <li class="flex-shrink-0">
          <img src="/images/t4.jpg" class="max-h-40 w-auto rounded-lg shadow-xl">
        </li>
        <li class="flex-shrink-0">
          <img src="/images/y6.jpg" class="max-h-40 w-auto rounded-lg shadow-xl">
        </li>
        <li class="flex-shrink-0">
          <img src="/images/v6.gif" class="max-h-40 w-auto rounded-lg shadow-xl">
        </li>
        
        
      </ul>
    </div>

    


    @livewire('main.posts')










    <div class="min-h-screen p-16 flex items-center justify-center rounded-lg shadow-xl">
      <section
        :aria-labelledby="title.toLowerCase().replace(' ', '-')"
        class="flex flex-col items-center justify-center w-full max-w-lg"
        @keydown.arrow-right="state.usedKeyboard = true;updateCurrent(nextSlide)"
        @keydown.arrow-left="state.usedKeyboard = true;updateCurrent(previousSlide)"
        @keydown.window.tab="state.usedKeyboard = true"
        x-data="testimonialSlideshow(slides)"
        x-title="Quotes Slideshow"
        x-init="setup()">
        <div
          :id="title.toLowerCase().replace(' ', '-')"
          class="sr-only" x-text="title">
        </div>
          <div
          tabindex="1"
          class="relative w-full overflow-hidden mb-6 bg-gray-300"
          :class="{'focus:outline-none' : !state.usedKeyboard}">
          <template x-for="(slide, index) in slides" :key="slide.id">
            <div :aria-hidden="(state.order[state.currentSlide] != slide.id).toString()">
              <div
                x-show="state.order[state.currentSlide] == slide.id"
                class="w-full text-center p-16"
                :x-ref="slide.id"
                :x-transition:enter="transitions('enter')"
                :x-transition:enter-start="transitions('enter-start')"
                :x-transition:enter-end="transitions('enter-end')"
                :x-transition:leave="transitions('leave')"
                :x-transition:leave-start="transitions('leave-start')"
                :x-transition:leave-end="transitions('leave-end')"
                >
                <blockquote>
                  <p
                    class="text-2xl font-extrabold italic mb-4 text-gray-800 leading-tight"
                    x-html="slide.content">
                  </p>
                  <footer><cite x-html="slide.author"></cite></footer>
                </blockquote>
              </div>
            </div>
          </template>
          <div
            x-cloak
            class="w-full bg-gray-200">
            <div
              class="bg-indigo-500 h-2 w-0"
              :class="{'progress': !state.moving}"
              :style="`animation-duration:${attributes.timer}ms;`">
            </div>
          </div>
        </div>
        <div
          aria-live="polite"
          aria-atomic="true"
          class="sr-only"
          x-text="'Slide ' + (state.currentSlide + 1) + ' of ' + slides.length">
        </div>
        <div>
          
        </div>
      </section>
    </div>
    
</div>