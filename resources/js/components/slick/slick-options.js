export const options = ({view}) => {
  if (view == 'product') {
    return {
      dots: true
    }
  }
  if (view == 'category') {
    return {
      dots: false,
      infinite: false,
      speed: 300,
      slidesToShow: 6,
      slidesToScroll: 6,
      responsive: [
        {
          breakpoint: 1024,
          settings: { slidesToShow: 4, slidesToScroll: 4, infinite: false }
        },
        {
          breakpoint: 600,
          settings: { slidesToShow: 3, slidesToScroll: 3 }
        },
        {
          breakpoint: 480,
          settings: { slidesToShow: 1, slidesToScroll: 1 }
        }
      ]
    }
  }
  if (view == 'collection') {
    return {
      slidesToShow: 1,
      dots: true,
    }
  }
  if (view == 'shop') {
    return {
      infinite: false,
      speed: 300,
      slidesToShow: 4,
      slidesToScroll: 4,
      responsive: [
        {
          breakpoint: 600,
          settings: { slidesToShow: 3, slidesToScroll: 3 }
        },
        {
          breakpoint: 480,
          settings: { slidesToShow: 1, slidesToScroll: 1, mobileFirst: true }
        }
      ]
    }
  }
  if (view == 'full-banner') {
    return {
      slidesToShow: 1,
      dots: false,
      infinite: true,
      autoplay: true,
      autoplaySpeed: 2500,
      responsive: [
        {
          breakpoint: 480,
          settings: {mobileFirst:true}
        }
      ]
    }
  }
}
