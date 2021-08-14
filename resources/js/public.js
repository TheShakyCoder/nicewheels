require('./bootstrap');

import { createApp } from 'vue'
import Vuex from 'vuex'

import ButtonBookmark from "./Static/Buttons/Bookmark"
import ButtonInformation from "./Static/Buttons/Information"
import ButtonLoadMore from "./Static/Buttons/LoadMore"
import ButtonRedeem from "./Static/Buttons/Redeem"
import ButtonReport from "./Static/Buttons/Report"
import ButtonShowSideFilter from "./Static/Buttons/ShowSideFilter"
import ComponentLoadMore from "./Static/Components/LoadMore"
import ModalGuest from "./Static/Modals/Guest"
import ModalInformation from "./Static/Modals/Information"
import ModalLogin from "./Static/Modals/Login"
import ModalRedeem from "./Static/Modals/Redeem"
import ModalSideFilter from "./Static/Modals/SideFilter"
import ModalStripe from "./Static/Modals/Stripe"
import StaticCars from "./Static/Components/Cars"
import StaticHeader from "./Static/Header"
import StaticImage from "./Static/Components/Image"
import StaticProfile from "./Static/Components/Profile"
import StaticRedeemedAmount from "./Static/Components/RedeemedAmount"

import VueIfBot from 'vue-if-bot/dist/vue-if-bot.es'
import CookieConsent from 'vue-cookieconsent-component/src/components/CookieConsent.vue'

import staticStore from './store/static'
const store = new Vuex.Store({
    modules: {
        static: staticStore,
    }
})

const app = createApp({
    components: {
        ButtonBookmark,
        ButtonInformation,
        ButtonLoadMore,
        ButtonRedeem,
        ButtonReport,
        ButtonShowSideFilter,
        ComponentLoadMore,
        ModalGuest,
        ModalInformation,
        ModalLogin,
        ModalRedeem,
        ModalSideFilter,
        ModalStripe,
        StaticCars,
        StaticHeader,
        StaticImage,
        StaticProfile,
        StaticRedeemedAmount,

        VueIfBot,
        CookieConsent
    },
    mounted () {
        const user = JSON.parse(localStorage.getItem('user', null))

        if(user) {
            //  TODO: get user update
            axios.post('/api/user', { api_token: user.api_token })
                .then(resp => {
                    this.$store.commit('static/setUser', { user: resp.data.user })
                    localStorage.setItem('user', JSON.stringify(resp.data.user))
                    this.getMyCars()
                })
        }
    },
    methods: {
        getMyCars () {
            const ids = this.$refs.ids.getAttribute('data-ids').replace('[', '').replace(']', '').split(',')
            const { api_token } = JSON.parse(localStorage.getItem('user', null))

            axios.post('/api/my-cars', { api_token, ids })
                .then(resp => {
                    this.$store.commit('static/setCollection', { collection: 'bookmarks', data: resp.data.myBookmarks })
                    this.$store.commit('static/setCollection', { collection: 'redemptions', data: resp.data.myRedemptions })
                })
        },
    }
})
.use(store)
.mount("#public")
