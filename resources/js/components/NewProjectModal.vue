<template>
  <modal name="create-project" classes="p-10 bg-card rounded-lg" height="auto">
    <form @submit.prevent="submit">
      <h1 class="font-normal mb-16 text-center text-2xl">Let's start something new!</h1>

      <div class="flex">
        <div class="flex-1 mr-4">
          <div class="mb-4">
            <label for="title" class="mb-2 text-sm block">Title</label>
            <input
              for="title"
              type="text"
              id="title"
              class="border p-2 text-ms block w-full"
              :class="errors.title ? 'border-red-700' : 'border-muted-light'"
              v-model="form.title"
            />
            <span class="text-xs italic text-red-400" v-if="errors.title" v-text="errors.title[0]"></span>
          </div>
          <div class="mb-4">
            <label for="description" class="mb-2 text-sm block">Description</label>
            <textarea
              for="description"
              id="description"
              class="border p-2 text-ms block w-full"
              :class="errors.description ? 'border-red-700' : 'border-muted-light'"
              rows="7"
              v-model="form.description"
            ></textarea>
            <span
              class="text-xs italic text-red-400"
              v-if="errors.description"
              v-text="errors.description[0]"
            ></span>
          </div>
        </div>

        <div class="flex-1 ml-4">
          <div class="mb-4">
            <label class="mb-2 text-sm block">Need some tasks?</label>
            <input
              type="text"
              id="title"
              class="border border-muted-light p-2 text-ms block w-full mb-2"
              placeholder="Task 1"
              v-for="task in form.tasks"
              v-bind:key="task.id"
              v-model="task.body"
            />
          </div>

          <button type="button" class="mr-2 text-xs text-green-500" @click="addTask">+ Add New Task Field...</button>
        </div>
      </div>

      <footer class="flex justify-end">
        <button class="mr-4 text-xs text-blue-500">Create Project</button>
        <button type="button" class="text-xs text-red-400" @click="$modal.hide('create-project')">Cancel</button>
      </footer>
    </form>
  </modal>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      form: {
        title: '',
        description: '',
        tasks: [
          { body: '' }
        ]
      },

      errors: {}
    };
  },

  methods: {
    addTask() {
      this.form.tasks.push({ value: '' });
    },

    submit() {
      axios.post('/projects', this.form)
        .then(res => {
          location = res.data.message;
        }).catch(err => {
          this.errors = err.response.data.errors;
        })
    }
  }
}
</script>
