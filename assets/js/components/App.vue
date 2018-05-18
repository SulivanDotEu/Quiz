<template>
    <div>
        <p>
            Vous avez {{ context.points }} point(s).
        </p>
        <question
                v-for="question in context.questions"
                v-bind:id="question.id"
                v-bind:question="question"
                v-bind:focus="focus"
                v-bind:key="question.id"
                v-on:select-answer="onSelectAnswer"
                v-on:confirm-answer="onConfirmAnswer"
                v-on:question-focus="changeFocus"
        ></question>
    </div>
</template>

<script>
    import Question from './Question'

    export default {
        components: {Question},
        data() {
            return {
                context: {
                    questions: {},
                    player: "",
                    points: 0,
                },
                focus: null,
            }
        },
        mounted() {
            this.$http.get(contextGet).then((response) => {

                this.context = response.data
                console.log(this.context)

            }, (response) => {
                console.log("erreur")
            })
        },
        methods: {
            changeFocus(value) {
                this.focus = value;
            },
            onSelectAnswer(data) {

                let _question = this.context.questions.find(k => k.id === data.question.id)
                let _questionIndex = this.context.questions.findIndex(k => k.id === data.question.id)
                let _answer = (data.answer === null) ? null : _question.answers.find(k => k.id === data.answer.id);

                this.context.questions[_questionIndex].selectedAnswer = _answer

                if(_answer === null)
                {
                    this.context.questions[_questionIndex].state = 'EMPTY';
                }
                else{
                    this.context.questions[_questionIndex].state = 'SELECTED';
                }

                this.submitAnswers();
            },
            onConfirmAnswer(data) {

                let _question = this.context.questions.find(k => k.id === data.question.id)
                let _questionIndex = this.context.questions.findIndex(k => k.id === data.question.id)
                this.context.questions[_questionIndex].state = 'CONFIRMED';

                this.submitAnswers();
            },
            submitAnswers() {

                console.log(this.context)

                this.$http.post(contextSubmit, this.context).then((response) => {

                    this.context = response.data
                    console.log(this.context)

                }, (response) => {

                    console.log("erreur")

                })

            }
        }
    }
</script>

