<template>
    <div>
        <question
                v-for="question in context.questions"
                v-bind:id="question.id"
                v-bind:label="question.label"
                v-bind:answers="question.answers"
                v-bind:selectedAnswer="question.selectedAnswer"
                v-bind:focus="focus"
                v-bind:key="question.id"></question>
    </div>
</template>

<script>
    import Question from './Question'

    export default {
        components: {Question},
        data() {
            return {
                context: {questions: {}},
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
            submitAnswers(){

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

