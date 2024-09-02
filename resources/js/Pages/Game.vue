<script setup lang="ts">
import { ref, onMounted } from 'vue';
import {router, usePage} from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps({
    game: Object
});

const count = ref(0);
const currentUser = usePage().props.user;
const playerMove = ref(null);
const opponentMove = ref(null);
const opponentHasMoved = ref(false);
const gameResult = ref(null);

const makeMove = async (move) => {
    router.post(`/game/${props.game.uuid}/move`, { move: move }, {
        preserveScroll: true,
        onSuccess: (data) => {
            playerMove.value = move;
        },
        onError: (error) => {
            console.error('Failed to send move');
        }
    });
};

onMounted(() => {
    Echo.join(`game.${props.game.id}`)
        .here((users) => {
            count.value = users.length;
        })
        .joining((user) => {
            count.value++;
        })
        .leaving((user) => {
            count.value--;
        })
        .listen('.PlayerMoved', (event) => {
            if (event.player !== currentUser.id) {
                opponentHasMoved.value = true;
            }
        })
        .listen('.GameResult', (event) => {
            const playerOne = parseInt(event.game.player_one);
            if (currentUser.id === playerOne) {
                opponentMove.value = event.game.player_two_move;
            } else {
                opponentMove.value = event.game.player_one_move;
            }

            gameResult.value = event.winner;
        });
});
</script>

<template>
    <div>
        <h1>Game</h1>
        <h2>Count: {{ count }}</h2>
        <h3>Current user {{ currentUser }}</h3>
        <h3>You are {{ parseInt(game.player_one) === currentUser.id ? 'Player one' : 'Player two' }}</h3>
        <hr>
        <div>
            <button @click="makeMove('rock')">Rock</button>
            <button @click="makeMove('paper')">Paper</button>
            <button @click="makeMove('scissors')">Scissors</button>
        </div>
        <div v-if="playerMove">
            <p>You chose: {{ playerMove }}</p>
        </div>
        <div v-if="opponentMove && playerMove">
            <p>Opponent chose: {{ opponentMove }}</p>
        </div>

        <div v-if="opponentHasMoved && !playerMove">
            <p>Opponent has chosen</p>
        </div>
        <hr>
        <div v-if="gameResult">
            <p v-if="gameResult === 'draw'">It's a draw!</p>
            <p v-else>
                {{ gameResult === (parseInt(game.player_one) === currentUser.id ? 'player_one' : 'player_two') ? 'You win!' : 'You lose!' }}
            </p>
        </div>
<!--        {{ game }}-->
    </div>
</template>
