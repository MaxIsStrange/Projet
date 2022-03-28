import { toast } from 'bulma-toast'
toast({
    message: 'Hello There',
    type: 'is-success',
    dismissible: true,
    pauseOnHover: true,
})

toast({
    message: '<h1>LOOK HERE</h1>',
    type: 'is-danger',
    dismissible: true,
    pauseOnHover: true,
    animate: { in: 'fadeIn', out: 'fadeOut' },
})

const myMessage = `It's ${new Date().toDateString()}`

toast({
    message: myMessage,
    type: 'is-primary',
    position: 'center',
    closeOnClick: true,
    pauseOnHover: true,
    opacity: 0.8,
})

const elm = document.createElement('a')
elm.text = 'Visit my website!'
elm.href = 'https://rfoel.com'

toast({
    message: elm,
    type: 'is-warning',
    position: 'center',
    closeOnClick: true,
    pauseOnHover: true,
    animate: { in: 'fadeIn', out: 'fadeOut' },
})