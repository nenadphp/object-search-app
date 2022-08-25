<template>
    <div class="container">
        <form @submit.prevent="handleSubmit">
            <div class="row justify-content-center">
                <h1 class="jumbotron mt-5">Search property</h1>
                <div class="col-3 pr-2">
                    <div class="form-outline mb-2">
                        <label class="form-label" for="name">Name</label>
                        <input v-model="name" type="text" id="name" name="name" class="form-control" />
                        <p v-if="nameError" class=" mt-1 text-danger"> {{ nameError }} </p>
                    </div>
                </div>
            </div>

            <div class="row mb-2 justify-content-center">
                <div class="col-1">
                    <div class="form-outline">
                        <label class="form-label">Bedrooms</label>

                        <select v-model="bedrooms" class="form-select">
                            <option value="0">---</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                </div>
                <div class="col-1">
                    <div class="form-outline">
                        <label class="form-label">Bathrooms</label>

                        <select v-model="bathrooms" class="form-select">
                            <option value="0">---</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                </div>
                <div class="col-1">
                    <div class="form-outline">
                        <label class="form-label">Storeys</label>

                        <select v-model="storeys" class="form-select">
                            <option value="0">---</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                </div>

                <div class="col-1">
                    <div class="form-outline">
                        <label class="form-label">Garages</label>

                        <select v-model="garages" class="form-select">
                            <option value="0">---</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-2">
                    <div class="form-outline mb-2">
                        <label class="form-label" for="priceMin">Min price</label>
                        <input v-model="priceMin" type="number" step="any" min="0" id="priceMin" name="priceMin" class="form-control" />
                    </div>
                </div>

                <div class="col-2">
                    <div class="form-outline mb-2">
                        <label class="form-label" for="priceMax">Max price</label>
                        <input v-model="priceMax" type="number" step="any" min="0" id="priceMax" name="priceMin" class="form-control" />
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mt-3">
                <div class="col-3 text-center">
                    <button type="submit" class="container btn btn-primary btn-sm">Search</button>
                </div>
            </div>
        </form>

        <div class="row mt-5">
            <Alert :title="noResultMessage" v-if="noResultMessage"/>
            <Loader v-if="loading" />
            <div class="row" v-if="data.length">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Bedrooms</th>
                            <th scope="col">Bathrooms</th>
                            <th scope="col">Storeys</th>
                            <th scope="col">Garages</th>
                            <th scope="col">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in data">
                            <th scope="row">{{ index }}</th>
                            <td>{{ item.name }}</td>
                            <td>{{ item.bedrooms }}</td>
                            <td>{{ item.bathrooms }}</td>
                            <td>{{ item.storeys }}</td>
                            <td>{{ item.garages }}</td>
                            <td>{{ item.price }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import Loader from '../layout/Loader.vue'
import Alert from '../layout/Alert.vue'

export default {
    components: {
        Loader, Alert
    },
    data() {
        return {
            name: '',
            bedrooms: 0,
            bathrooms: 0,
            storeys: 0,
            garages: 0,
            priceMin: 0,
            priceMax: 1000000,
            nameError: '',
            data: [],
            loading: false,
            noResultMessage : ''
        }
    },
    methods: {
        handleSubmit() {
            if (!this.validateInputs()) {
                // Small Example of form validation
                return false;
            }

            this.loading = true;
            this.data = []
            this.nameError = ''
            this.noResultMessage = ''

            axios.get(import.meta.env.VITE_APP_AXIOS_BASE_URL + '/api/property/search', {
                params: {
                    'name': this.name,
                    'bedrooms': parseInt(this.bedrooms),
                    'bathrooms': parseInt(this.bathrooms),
                    'storeys': parseInt(this.storeys),
                    'garages': parseInt(this.garages),
                    'priceMin': this.priceMin,
                    'priceMax': this.priceMax,
                }
            })
            .then((response) => {
                this.data = response.data
                if (this.data.length === 0) {
                    this.noResultMessage = "There is no result by terms";
                }

                this.loading = false;
            }).catch(errors => {
                console.log(errors)
            })
        },
        validateInputs () {
            // Small Example of form validation
            if (!this.name.length) {
                this.nameError = 'Name is is required';
                return false;
            } else if(this.name.length < 2) {
                this.nameError = 'Name must be at lest 2 chars long';
                return false;
            }

            return true;
        }
    }
}

</script>
