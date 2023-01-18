<script>
import axios from "axios";

export default {
    props: {
        token: Object,
    },
    methods: {
        generateNewToken() {
            axios.patch(route('token.update'), {
                token: this.personalToken,
                active: true,
                update_token: true
            })
                .then(response => {
                    this.personalToken = response.data.data.token.token;
                    history.pushState(null, null, `/dashboard/${this.personalToken}`)
                })
                .catch(error => {
                    this.error = error;
                })
        },
        changeActivation() {
            axios.patch(route('token.update'), {
                token: this.personalToken,
                active: !this.isActive,
                update_token: false
            })
                .then(() => {
                    this.isActive = !this.isActive;
                })
                .catch(error => {
                    this.error = error;
                })
        },
        play() {
            axios.get(route('game'))
                .then(result => {
                    this.gameResult = result.data
                })
                .catch(error => {
                    this.error = error;
                })
        },
        showHistory() {
            axios.get(route('history'))
                .then(result => {
                    this.gameHistory = result.data.data[0]
                })
                .catch(error => {
                    this.error = error;
                })
        }
    },
    data() {
        return {
            isActive: this.token.active === 1,
            personalToken: this.token.token,
            gameResult: [],
            gameHistory: [],
            error: ''
        }
    }
}
</script>
<template>
    <div>
        <h1 class="font-bold text-3xl text-center mt-4">
            Dashboard
        </h1>
    </div>
    <div class="text-center bg-red-500 border-red-600 text-white" v-if="error">
        {{error.response.data.message}}
    </div>
    <div class="mt-4 ml-5">
        <div class="flex flex-col">
            <div class="flex">
                <label class="font-semibold text-lg mr-9" for="token">Your token</label>
                <input id="token" class="form-input w-3/5" disabled v-model="personalToken">
                <button class="ml-2 bg-blue-500 p-2 rounded text-white hover:bg-blue-800" v-on:click="generateNewToken">
                    Generate new token
                </button>
            </div>
            <div class="flex mt-5">
                <label class="font-semibold text-lg mr-5" for="isActive">Active token</label>
                <input id="isActive" class="form-input w-1/12" v-model="isActive">
                <button class=" ml-2 bg-blue-500 p-2 rounded text-white hover:bg-blue-800" v-on:click="changeActivation">
                    {{isActive ? 'Deactivate' : 'Activate'}}
                </button>
            </div>
        </div>
        <div class="flex justify-around mt-5">
            <div class="border-2 p-4 h-1/3">
                <div class="text-lg">Game</div>
                <div class="mt-2">
                    <div>
                        <div class="text-lg font-semibold">Result</div>
                        <div v-for="item in gameResult">
                            <li>
                                Number: {{item.number}}
                            </li>
                            <li>
                                Status: {{item.status}}
                            </li>
                            <li>
                                Gain: {{item.gain}}
                            </li>
                        </div>
                    </div>
                    <button class="bg-blue-500 p-2 rounded text-white mt-2" v-on:click="play">
                        Im feeling lucky
                    </button>
                </div>
            </div>
            <div class="border-2 p-4">
                <div class="text-lg">Game history</div>
                <div class="mt-2" v-for="item in gameHistory">
                    <div class="text-lg font-semibold">Game {{item.id}}</div>
                    <li>
                        Status : {{item.game_status}}
                    </li>
                    <li>
                        Gain : {{item.gain}}
                    </li>
                </div>
                <button class="bg-blue-500 p-2 rounded text-white mt-2" v-on:click="showHistory">
                    History
                </button>
            </div>
        </div>
    </div>
</template>
