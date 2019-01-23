<template>
    <table class="table">
        <thead>
        <tr>
            <td><strong>Options</strong></td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(option, index) in data" v-bind:key="index">
            <td>
                <div class="input-group">
                    <input type="text" class="form-control"v-model="option.name" @keydown.enter="addRow"/>
                </div>
            </td>
            <td>
                <button type="button" @click="btnAction(index)" :class="btnClass" style="cursor: pointer">{{btnName}}</button>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "AutoInputField",
        props: {
            data: {
                type: Array,
                required: true
            },
            newInputEvent: {
                type: Boolean,
                default: false
            },
            btnClass: {
                type: [String, Array],
                default: 'btn btn-danger'
            },
            btnName: {
                type: String,
                default: 'Remove'
            },
            btnAction: Function
        },
        methods: {
            addRow: function() {
                if (this.newInputEvent) {
                    this.data.push({
                        name: ""
                    });
                }
            }
        }
    }
</script>

<style scoped>

</style>