<template>
    <div>
        <div v-if="info.data.prize.status === 'suggested'">
            <h1>You won prize</h1>
            <h2 v-if="info.data.type === 'shipment'">{{info.data.prize.name}}</h2>
            <h2 v-if="info.data.type === 'bonus'">{{info.data.prize.amount}} bonuses</h2>
            <h2 v-if="info.data.type === 'cash'">{{info.data.prize.amount}}$</h2>

            <button type="button" class="btn btn-default" @click="changePrizeStatus($event, 'accepted', info.data)">
                Accept
            </button>
            <button type="button" class="btn btn-default" @click="changePrizeStatus($event, 'cancelled', info.data)">
                Cancel
            </button>
        </div>

        <div v-if="info.data.prize.status === 'accepted'">
            <h1>You accept prize</h1>
            <div v-if="info.data.type === 'cash'">
                <button type="button" class="btn btn-default"
                        @click="changePrizeStatus($event, 'converted', info.data)">Convert to bonus
                </button>
                <button type="button" class="btn btn-default"
                        @click="changePrizeStatus($event, 'withdrawal', info.data)">Withdrawal
                </button>
            </div>

            <div v-if="info.data.type === 'shipment'">
                <button type="button" class="btn btn-default" @click="changePrizeStatus($event, 'sent', info.data)">
                    Send
                </button>
            </div>
        </div>

        <h2 v-if="info.data.prize.status === 'converted'">Your cash price converted to bonuses</h2>
        <h2 v-if="info.data.prize.status === 'withdrawal'">Your cash price withdrawal</h2>
        <h2 v-if="info.data.prize.status === 'sent'">You shipment sent</h2>

        <div v-if="info.data.prize.status === 'cancelled'">
            <h1>You cancel prize</h1>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                info: null
            };
        },

        methods: {
            changePrizeStatus(evt, status, prize) {
                evt.preventDefault();
                this.$http.put('prize/' + prize.type + '/' + prize.prize.id + '/' + status)
                    .then(response => (this.info = response));
            }
        },

        mounted() {
            this.$http.get('prize/random')
                .then(response => (this.info = response));
        },
    }
</script>