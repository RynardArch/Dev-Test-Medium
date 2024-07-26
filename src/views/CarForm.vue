<template>
  <v-container>
    <v-form @submit.prevent="submitForm">
      <!-- form fields here -->
      <v-btn type="submit" color="primary">Submit</v-btn>
    </v-form>
  </v-container>
</template>

<script>
import apiClient from '../axios'; // Ensure you have axios setup in your project

export default {
  data() {
    return {
      car: {
        friend_name: '',
        car_type: '',
        car_cost: '',
        date_bought: '',
      },
    };
  },
  methods: {
    submitForm() {
      apiClient.post('/cars', this.car)
        .then(response => {
          console.log('Car created:', response.data);
          this.$router.push({ name: 'CarList' }); // Navigate to the list view
        })
        .catch(error => {
          console.error('Error creating car:', error);
        });
    },
  },
};
</script>
