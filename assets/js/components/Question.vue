<template>
    <div v-on:mouseover="mouseOver">
        <div class="pull-right">
            <div class="dropdown" v-show="active" :class="{ dropdown: state !== 'confirmed' }">
                <button class="btn btn-primary dropdown-toggle"
                        :class="{disabled: state === 'CONFIRMED'}"
                        type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Pouvoir
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Aide à un ami</a>
                    <a class="dropdown-item" href="#">Vote du public</a>
                    <a class="dropdown-item" href="#">50/50</a>
                </div>
            </div>
        </div>
        <h2>
            <i class="fa fa-arrow-circle-right" v-if="active"></i>
            <i class="fa fa-circle-o" v-else-if="state === 'EMPTY'"></i>
            <i class="fa fa-check-circle" v-else-if="state === 'CONFIRMED'"></i>
            <i class="fa fa-dot-circle-o" v-else></i>

            {{ label }}
        </h2>
        <!--<button @click.prevent="changeLabel">Label</button>-->
        <ul class="list-unstyled">
            <li v-for="answer in answers">
                <button
                        class="btn"
                        @click.prevent="selectAnswer(answer)"
                        :class="{
                            active: answer === selectedAnswer && state !== 'CONFIRMED',
                            'btn-light': state !== 'CONFIRMED' || answer !== selectedAnswer,
                            disabled: !active || (state === 'CONFIRMED' && answer !== selectedAnswer),
                            'btn-primary': answer === selectedAnswer && state === 'CONFIRMED',
                         }">
                    {{ answer.label }}
                </button>

                <button class="btn btn-success" @click.prevent="confirmAnswer()"
                        v-show="answer === selectedAnswer && active && state != 'CONFIRMED'">
                    <i class="fa fa-check"></i>
                    Confirmer votre choix
                </button>
                <button class="btn btn-danger" @click.prevent="cancelAnswer()"
                        v-show="answer === selectedAnswer && active && state != 'CONFIRMED'">
                    <i class="fa fa-close"></i>
                    Annuler votre choix
                </button>
            </li>
        </ul>
    </div>
</template>

<script>

    const STATE_EMPTY = "EMPTY";
    const STATE_SELECTED = "SELECTED";
    const STATE_CONFIRMED = "CONFIRMED";

    export default {
        props: ['id', 'label', 'answers', 'focus'],
        data() {
            return {
                selectedAnswer: null,
                state: STATE_EMPTY
            }
        },
        computed: {
            active() {
                return this.focus === this.id
            }
        },
        methods: {
            selectAnswer(answer) {
                if (this.state == STATE_CONFIRMED) return;
                if (this.selectedAnswer === answer) {
                    this.cancelAnswer();
                    return;
                }
                this.selectedAnswer = answer
                this.state = STATE_SELECTED
                this.$parent.submitAnswers()
            },
            mouseOver() {
                this.$parent.changeFocus(this.id);
            },
            cancelAnswer() {
                this.selectedAnswer = null;
                this.state = STATE_EMPTY;
            },
            confirmAnswer() {
                this.state = STATE_CONFIRMED
                this.$parent.submitAnswers()
            }
        },
    }
</script>

