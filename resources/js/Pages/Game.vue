<script setup lang="ts">
import Share from '@/Components/Share.vue'
import { ref, onMounted, computed } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'

const props = defineProps({
    game: Object,
    gameFinished: Boolean,
    currentPlayer: String,
    opponentPlayer: String,
    currentPlayerMove: String,
    opponentPlayerMove: String,
    winner: String
})

const count = ref(0)
const currentUser = usePage().props.user
const playerMove = ref(null)
const opponentMove = ref(null)
const opponentHasMoved = ref(false)
const winner = ref(null)
const rematchRequested = ref(false)

const makeMove = async (move) => {
    router.post(`/game/${props.game.uuid}/move`, { move }, {
        preserveScroll: true,
        onSuccess: (data) => {
            playerMove.value = move
        },
        onError: (error) => {
            console.error('Failed to send move')
        }
    })
}

function joinGame () {
    router.post(`/game/${props.game.uuid}/join`, {}, {
        preserveScroll: true,
        onSuccess: (data) => {
            router.reload()
        },
        onError: (error) => {
            console.error('Failed to join game')
        }
    })
}

function requestRematch () {
    router.post(`/game/${props.game.uuid}/rematch`, {}, {
        preserveScroll: true,
        onSuccess: (data) => {
            router.reload()
        },
        onError: (error) => {
            console.error('Failed to join game')
        }
    })
}

function denyRematch () {
    router.post(`/game/${props.game.uuid}/rematch/deny`, {}, {
        preserveScroll: true,
        onSuccess: (data) => {
            router.reload()
        },
        onError: (error) => {
            console.error('Failed to join game')
        }
    })
}

function acceptRematch () {
    router.post(`/game/${props.game.uuid}/rematch/accept`, {}, {
        preserveScroll: true,
        onSuccess: (data) => {
            router.reload()
        },
        onError: (error) => {
            console.error('Failed to join game')
        }
    })
}

function reset () {
    playerMove.value = null
    opponentMove.value = null
    opponentHasMoved.value = false
    winner.value = null
    rematchRequested.value = false
}

onMounted(() => {
    if (props.currentPlayerMove) {
        playerMove.value = props.currentPlayerMove
    }

    if ((!props.game.player_two || !props.game.player_one) && props.currentPlayer === 'spectator') {
        joinGame()
    }

    if (props.gameFinished) {
        opponentHasMoved.value = true
        opponentMove.value = props.opponentPlayerMove
        winner.value = props.winner
    }

    Echo.join(`game.${props.game.id}`)
        .here((users) => {
            count.value = users.length
        })
        .joining((user) => {
            count.value++
        })
        .leaving((user) => {
            count.value--
        })
        .listen('.PlayerMoved', (event) => {
            if (event.player !== currentUser.id) {
                opponentHasMoved.value = true
            }
        })
        .listen('.GameResult', (event) => {
            const playerOne = parseInt(event.game.player_one)
            if (currentUser.id === playerOne) {
                opponentMove.value = event.game.player_two_move
            } else {
                opponentMove.value = event.game.player_one_move
            }

            winner.value = event.winner
        })
        .listen('.RematchRequested', (event) => {
            if (event.player !== currentUser.id) {
                rematchRequested.value = true
            }
        })
        .listen('.RematchDenied', (event) => {
            if (event.player !== currentUser.id) {
                alert('Opponent denied rematch')
            }
        })
        .listen('.RematchAccepted', (event) => {
            router.reload({
                onSuccess: () => {
                    reset()
                }
            })
        })
})
</script>

<template>
    <div>
        <div class="flex justify-between">
            <h1>Game: {{ game.uuid }}</h1>
            <Link href="/game/new">
                New game
            </Link>
        </div>
        <hr>
        <Share
            :url="`/${game.uuid}`"
            title="Play Rock Paper Scissors"
            description="Join the game" />
        <h2>Current players: {{ count }}</h2>
        <!--        <h3>Current user {{ currentUser }}</h3>-->
        <!--        <h3>You are {{ parseInt(game.player_one) === currentUser.id ? 'Player one' : 'Player two' }}</h3>-->
        <hr>
        <div v-if="currentPlayer === 'spectator'">
            <p>You have missed the game</p>
        </div>

        <div v-else>
            <div v-if="count === 2">
                <p>Choose your move:</p>
                <ul class="flex items-center gap-8 text-4xl mt-8">
                    <li>
                        <button
                            class="bg-black/20 px-4 py-1 rounded-full disabled:opacity-50"
                            :disabled="playerMove"
                            @click="makeMove('rock')">
                            🪨 Rock
                        </button>
                    </li>
                    <li>
                        <button
                            class="bg-black/20 px-4 py-1 rounded-full disabled:opacity-50"
                            :disabled="playerMove"
                            @click="makeMove('paper')">
                            📄 Paper
                        </button>
                    </li>
                    <li>
                        <button
                            class="bg-black/20 px-4 py-1 rounded-full disabled:opacity-50"
                            :disabled="playerMove"
                            @click="makeMove('scissors')">
                            ✂️ Scissors
                        </button>
                    </li>
                </ul>
            </div>
            <div v-if="playerMove">
                <p>You chose: {{ playerMove }}</p>
                <p v-if="!opponentMove">
                    Waiting for opponent to choose...
                </p>
            </div>

            <div v-if="opponentMove && playerMove">
                <p>Opponent chose: {{ opponentMove }}</p>
            </div>

            <div v-if="opponentHasMoved && !playerMove">
                <p>Opponent has chosen, it's your turn</p>
            </div>
            <hr>
            <div v-if="winner">
                <strong>Winner:</strong>
                <p v-if="winner === 'draw'">
                    It's a draw!
                </p>
                <div v-else>
                    <p v-if="winner === currentPlayer">
                        You win!
                    </p>
                    <p v-if="winner === opponentPlayer">
                        You lose!
                    </p>
                </div>

                <button
                    v-if="!rematchRequested"
                    @click="requestRematch">
                    Request rematch
                </button>

                <div v-if="rematchRequested">
                    <p>Rematch requested</p>
                    <button @click="acceptRematch">
                        Lets do it
                    </button>
                    <button @click="denyRematch">
                        No, loser
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
