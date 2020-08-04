import Notification from './components/notification.js'
import Loading from './components/loading.js'
import Dropdown from './components/dropdown.js'
import Auth from './auth/auth.js'
import Posts from './posts/posts.js'
import Actions from './components/actions.js'
import Utils from './components/utils.js';

/**
 |--------------------------------------------------------------------------
 | Main App class
 |--------------------------------------------------------------------------
 |
 | This class will be instantiated on every request and will be used to
 | instantiate all other classes + pass down certain 'helper' methods.
 |
 */
class App {

    constructor() {
        this.Loading = new Loading
        this.Notification = new Notification
        this.Utils = new Utils
        new Auth(this.Loading)
        new Posts(this.Loading, this.Notification)
        new Dropdown
        new Actions(this.Utils, this.Notification)
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new App
})
