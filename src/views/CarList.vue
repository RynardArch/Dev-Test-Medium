<template>
  <v-container>
    <v-btn @click="showAddDialog" color="primary">
      Add Car
    </v-btn>

    <v-data-table :headers="headers" :items="cars" item-key="id" class="elevation-1">
      <template v-slot:[`item.actions`]="{ item }">
        <v-btn @click="showEditDialog(item)" icon>
          <v-icon>mdi-pencil</v-icon>
        </v-btn>
        <v-btn @click="confirmDelete(item.id)" icon>
          <v-icon>mdi-delete</v-icon>
        </v-btn>
      </template>
    </v-data-table>

    <!-- Add Car Dialog -->
    <v-dialog v-model="showAdd" max-width="500px">
      <v-card>
        <v-card-title>
          <span class="headline">Add New Car</span>
        </v-card-title>
        <v-card-subtitle>
          <v-form ref="form">
            <v-text-field v-model="newCar.friend_name" label="Owner Name"></v-text-field>
            <v-text-field v-model="newCar.car_type" label="Car Type"></v-text-field>
            <v-text-field v-model="newCar.car_cost" label="Car Cost" type="number"></v-text-field>
            <v-text-field v-model="newCar.date_bought" label="Date Bought" type="date"></v-text-field>
          </v-form>
        </v-card-subtitle>
        <v-card-actions>
          <v-btn @click="addCar" color="primary">Add</v-btn>
          <v-btn @click="showAdd = false" color="secondary">Cancel</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Edit Car Dialog -->
    <v-dialog v-model="showEdit" max-width="500px">
      <v-card>
        <v-card-title>
          <span class="headline">Edit Car</span>
        </v-card-title>
        <v-card-subtitle>
          <v-form ref="form">
            <v-text-field v-model="selectedCar.friend_name" label="Owner Name"></v-text-field>
            <v-text-field v-model="selectedCar.car_type" label="Car Type"></v-text-field>
            <v-text-field v-model="selectedCar.car_cost" label="Car Cost" type="number"></v-text-field>
            <v-text-field v-model="selectedCar.date_bought" label="Date Bought" type="date"></v-text-field>
          </v-form>
        </v-card-subtitle>
        <v-card-actions>
          <v-btn @click="updateCar" color="primary">Save</v-btn>
          <v-btn @click="showEdit = false" color="secondary">Cancel</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Delete Confirmation Dialog -->
    <v-dialog v-model="showDeleteConfirm" max-width="500px">
      <v-card>
        <v-card-title>
          <span class="headline">Confirm Deletion</span>
        </v-card-title>
        <v-card-subtitle>
          Are you sure you want to delete this car?
        </v-card-subtitle>
        <v-card-actions>
          <v-btn @click="deleteCar" color="red">Delete</v-btn>
          <v-btn @click="showDeleteConfirm = false" color="secondary">Cancel</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>


<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

// Define the table headers
const headers = ref([
  { text: 'Friend Name', value: 'friend_name' },
  { text: 'Car Type', value: 'car_type' },
  { text: 'Car Cost', value: 'car_cost' },
  { text: 'Date Bought', value: 'date_bought' },
  { text: 'Actions', value: 'actions', sortable: false }
]);

// Define reactive variables for storing the cars data
const cars = ref([]);

// Define reactive variables for dialogs and form
const showAdd = ref(false);
const showEdit = ref(false);
const showDeleteConfirm = ref(false);
const newCar = ref({
  friend_name: '',
  car_type: '',
  car_cost: '',
  date_bought: ''
});
const selectedCar = ref(null);
const carIdToDelete = ref(null);

// Fetch the data when the component is mounted
onMounted(async () => {
  await fetchCars();
});

// Fetch cars data from the server
const fetchCars = async () => {
  try {
    const response = await axios.get('/cars');
    cars.value = response.data;
  } catch (error) {
    console.error('Error fetching cars data:', error);
  }
};

// Show the Add Car dialog
const showAddDialog = () => {
  showAdd.value = true;
};

// Add a new car
const addCar = async () => {
  try {
    await axios.post('/cars', newCar.value);
    // Clear the form and close the dialog
    newCar.value = { friend_name: '', car_type: '', car_cost: '', date_bought: '' };
    showAdd.value = false;
    // Refetch cars to refresh the list
    await fetchCars();
  } catch (error) {
    console.error('Error adding car:', error);
  }
};

// Show the Edit Car dialog with selected car data
const showEditDialog = (car) => {
  selectedCar.value = { ...car }; // Clone the car object to avoid direct mutation
  showEdit.value = true;
};

// Update an existing car
const updateCar = async () => {
  try {
    await axios.put(`/cars/${selectedCar.value.id}`, selectedCar.value);
    await fetchCars(); // Refetch cars to reflect the update
    showEdit.value = false; // Close dialog
  } catch (error) {
    console.error('Error updating car:', error);
  }
};

// Confirm delete car
const confirmDelete = (id) => {
  carIdToDelete.value = id;
  showDeleteConfirm.value = true;
};

// Delete a car
const deleteCar = async () => {
  try {
    await axios.delete(`/cars/${carIdToDelete.value}`);
    await fetchCars(); // Refetch cars to reflect the deletion
    showDeleteConfirm.value = false; // Close dialog
  } catch (error) {
    console.error('Error deleting car:', error);
  }
};
</script>
