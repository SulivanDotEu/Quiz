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

            {{ question.label }} {{ selectedAnswerId }}
        </h2>
        <!--<button @click.prevent="changeLabel">Label</button>-->
        <ul class="list-unstyled">
            <li v-for="answer in question.answers">
                <button
                        class="btn"
                        @click.prevent="selectAnswer(answer)"
                        :class="{
                            active: answer.id === selectedAnswerId && state !== 'CONFIRMED',
                            'btn-light': state !== 'CONFIRMED' || answer.id !== selectedAnswerId,
                            disabled: !active || (state === 'CONFIRMED' && answer.id !== selectedAnswerId),
                            'btn-primary': answer.id === selectedAnswerId && state === 'CONFIRMED',
                         }">
                    {{ answer.label }}
                </button>

                <button class="btn btn-success" @click.prevent="confirmAnswer()"
                        v-show="answer.id === selectedAnswerId && active && state != 'CONFIRMED'">
                    <i class="fa fa-check"></i>
                    Confirmer votre choix
                </button>
                <button class="btn btn-danger" @click.prevent="cancelAnswer()"
                        v-show="answer.id === selectedAnswerId && active && state != 'CONFIRMED'">
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
        props: ['focus', 'question'],
        data() {
            return {
                state: STATE_EMPTY,
                // question: {
                //     id: null,
                //     label: 'AAA',
                //     answers: [],
                //     selectedAnswer: null
                // },
            }
        },
        computed: {
            active() {
                if(this.focus === null) return false;
                return this.focus.id === this.question.id
            },
            selectedAnswerId() {
                return this.question.selectedAnswer ? this.question.selectedAnswer.id : 0;
            }
        },
        methods: {
            selectAnswer(answer) {
                if (this.state === STATE_CONFIRMED) return;
                if (this.question.selectedAnswer === answer) {
                    this.cancelAnswer();
                    return;
                }
                this.state = STATE_SELECTED
                this.$emit('select-answer', {question: this.question, answer: answer})
            },
            mouseOver() {
                this.$parent.changeFocus(this.question);
            },
            cancelAnswer() {
                this.$emit('select-answer', {question: this.question, answer: null})
                this.state = STATE_EMPTY;
            },
            confirmAnswer() {
                this.state = STATE_CONFIRMED
                this.$emit('confirm-answer', {question: this.question, answer: this.question.selectedAnswer})
            }
        },
    }
</script>

