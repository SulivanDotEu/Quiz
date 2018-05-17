<template>
    <div>
        <question
                v-for="question in context.questions"
                v-bind:id="question.id"
                v-bind:question="question"
                v-bind:focus="focus"
                v-bind:key="question.id"
                v-on:select-answer="onSelectAnswer"
                v-on:confirm-answer="onSelectAnswer"
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
                    player: ""
                },
                focus: null,
            }
        },
        mounted() {
            this.$http.get('/api/context').then((response) => {

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

                console.log(data)
                let _question = this.context.questions.find(k => k.id === data.question.id)
                let _questionIndex = this.context.questions.findIndex(k => k.id === data.question.id)
                let _answer = (data.answer === null) ? null : _question.answers.find(k => k.id === data.answer.id);

                console.log(_question, _answer)

                this.context.questions[_questionIndex].selectedAnswer = _answer

                this.submitAnswers();
            },
            submitAnswers() {

                console.log(this.context)

                this.$http.post('/api/submit', this.context).then((response) => {

                    this.context = response.data
                    console.log(this.context)

                }, (response) => {

                    console.log("erreur")

                })

            }
        }
    }
</script>

