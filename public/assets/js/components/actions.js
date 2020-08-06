import ROUTES from './routes.js';
/**
 |--------------------------------------------------------------------------
 | Actions class
 |--------------------------------------------------------------------------
 |
 | This class will deal with commomn user actions, such as 'likes', 'adding'
 | a post to their read list, etc.
 |
 |
 */
export default class Actions {

    constructor(Utils, Notification) {
        this.Utils = Utils
        this.Notification = Notification
        this.likeButtons = document.querySelectorAll('.button--like')
        this.likeButtons.forEach(item => {
            this.animate(item)
            this.afterAnimate(item)
        })
        this.bookmarkButtons = document.querySelectorAll('.button--bookmark')
        this.bookmarkButtons.forEach(item => {
              this.bookmark(item)
        })
    }

    animate = (item) => {
        item.addEventListener('click', () => {
            if (item.classList.contains('animated')) {
                this.unlike(item).then(data => {
                    if (data.result) {
                        item.classList.remove('animated')
                        item.classList.add('nanimated')
                        this.disableButton(item)
                    } else {
                        this.Notification.show({
                            isPrompt: true,
                            message: data.message,
                            imgPath: ROUTES.ERROR_IMAGE,
                        })
                    }
                })
            } else {
                this.like(item).then(data => {
                    if (data.result) {
                        item.classList.toggle('animate')
                        item.classList.remove('nanimated')
                    } else {
                        this.Notification.show({
                            isPrompt: true,
                            message: data.message,
                            imgPath: ROUTES.ERROR_IMAGE,
                        })
                    }
                })
            }
        })
    }

    afterAnimate = (item) => {
        item.addEventListener('animationend', () => {
            item.classList.toggle('animate')
            item.classList.add('animated')
        })
    }

    like = (item) => {
        let data = {
            article: item.dataset.articleId,
            table: 'likes',
            column: 'liked_by',
        }
        return this.Utils.fetchJsonData(ROUTES.USER_ADD, data)
    }

    unlike = (item) => {
        let data = {
            article: item.dataset.articleId,
            table: 'likes',
            column: 'liked_by',
        }
        return this.Utils.fetchJsonData(ROUTES.USER_REMOVE, data)
    }

    disableButton = (item) => {
        item.disabled = true
        setTimeout(() => {
            item.disabled = false
        }, 10000)
    }

    bookmark = (item) => {
        item.addEventListener('click', () => {
            let data = {
                article: item.dataset.articleId,
                table: 'bookmarks',
                column: 'bookmarked_by',
            }
            if (item.classList.contains('bookmarked')) {
                this.Utils.fetchJsonData(ROUTES.USER_REMOVE, data)
                  .then(data => {
                      if (data.result) {
                          item.classList.remove('bookmarked')
                          this.disableButton(item)
                          if (item.classList.contains('button--bookmark--mini')) {
                              item.getElementsByTagName('i')[0].classList.replace('fas', 'far')
                          } else {
                              item.innerText = 'SAVE'
                          }
                      } else {
                          this.Notification.show({
                              isPrompt: true,
                              message: data.message,
                              imgPath: ROUTES.ERROR_IMAGE,
                          })
                      }
                  })
            } else {
                this.Utils.fetchJsonData(ROUTES.USER_ADD, data)
                  .then(data => {
                      if (data.result) {
                          item.classList.add('bookmarked')
                          if (item.classList.contains('button--bookmark--mini')) {
                              item.getElementsByTagName('i')[0].classList.replace('far', 'fas')
                          } else {
                              item.innerText = 'SAVED'
                          }
                      } else {
                          this.Notification.show({
                              isPrompt: true,
                              message: data.message,
                              imgPath: ROUTES.ERROR_IMAGE,
                          })
                      }
                  })
            }
        })
    }
}
