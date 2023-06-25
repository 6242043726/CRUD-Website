<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homework 5 | CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script type="importmap">
        {
    "imports": {"vue": "https://unpkg.com/vue@3/dist/vue.esm-browser.js"}
        }
    </script>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require 'script.php'; ?>
    <script type="module">
        import {
            createApp
        } from 'vue'
        createApp({
            data() {
                return {
                    contacts: [],
                    selected: '',
                    prefix: '',
                    first: '',
                    last: '',
                    email: ''
                }
            },
            created() {
                fetch("contacts.json").then(response => response.json()).then(data => {
                    this.contacts = data
                });
            },
            computed: {
                filteredNames() {
                    return this.contacts.filter((n) =>
                        n.toLowerCase().startsWith(this.prefix.toLowerCase())
                    )
                }
            },
            watch: {
                selected(name) {
                    ;
                    [this.first, this.last, this.email] = name.split(', ')
                }
            },
            methods: {
                create() {
                    if (this.hasValidInput()) {
                        const fullContact = `${this.first}, ${this.last}, ${this.email}`
                        if (!this.contacts.includes(fullContact)) {
                            this.contacts.push(fullContact)
                            this.first = this.last = this.email = ''
                        }
                    }
                },
                update() {
                    if (this.hasValidInput() && this.selected) {
                        const i = this.contacts.indexOf(this.selected)
                        this.contacts[i] = this.selected = `${this.first}, ${this.last}, ${this.email}`
                        this.first = this.last = this.email = ''
                    }
                },
                del() {
                    if (this.selected) {
                        const i = this.contacts.indexOf(this.selected)
                        this.contacts.splice(i, 1)
                        this.selected = this.first = this.last = this.email = ''
                    }
                },
                clear() {
                    this.first = this.last = this.email = ''
                },
                hasValidInput() {
                    return this.first.trim() && this.last.trim() && this.email.trim()
                },
                sortaz() {
                    this.contacts.sort((a, b) => a.toLowerCase().localeCompare(b.toLowerCase()));
                },
                sortza() {
                    this.contacts.sort((a, b) => b.toLowerCase().localeCompare(a.toLowerCase()));
                }
            }
        }).mount('#app')
    </script>
    <!-- content -->
    <div id="app">
        <div class="container mt-5">
            <div class="row mb-2">
                <h1>Homework 5 | CRUD Application</h1>
            </div>
            <form action="" method="post">
                <div style="width: 200px;"><label>Search:<input v-model="prefix" placeholder="Filter prefix" class="form-control"></label></div>
                <div class="row d-flex justify-content-start">
                    <div class="col-md-auto">
                        <label>Contacts (First name, Last name, Email):
                            <select size="5" v-model="selected" class="form-control">
                                <option v-for="name in filteredNames">{{ name }}</option>
                            </select>
                        </label>
                    </div>
                    <div class="col-md-auto">
                        <div class="row row-cols-auto">
                            <label>Name: <input type="text" name="first" v-model="first" class="form-control"></label>
                            <label>Surname: <input type="text" name="last" v-model="last" class="form-control"></label>
                        </div>
                        <div class="row-md-auto">
                            <label>Email: <input type="email" name="email" v-model="email" class="form-control"></label>
                        </div>
                        <div class="row-md-auto">
                            <input type="text" name="contacts" v-model="contacts" v-show="false" class="form-control">
                        </div>
                        <div class="row-md-auto">
                            <button class="btn btn-danger" type="submit" name="submit" onclick="return confirm('Save Contacts to JSON file?')">Save to Json</button>
                            <button class="btn btn-warning" onClick="history.go(0);">Refresh Page</button>
                            <h6 class="error"><?php echo @$error; ?></h6>
                            <h6 class="success"><?php echo @$success; ?></h6>
                        </div>
                    </div>
                </div>
            </form>
            <div class="buttons mt-3">
                <hr>
                <button class="btn btn-primary" @click="create">Create</button>
                <button class="btn btn-primary" @click="update">Update</button>
                <button class="btn btn-primary" @click="del">Delete</button>
                <button class="btn btn-primary" @click="clear">Clear</button>
                <hr>
                <button class="btn btn-success" @click="sortaz">Sort Contacts A-Z</button>
                <button class="btn btn-success" @click="sortza">Sort Contacts Z-A</button>
            </div>
        </div>
    </div>
    <!-- footer -->
    <footer class="footer mt-auto bg-light text-center">
        <div class="container p-3">
            <h6>© 2022 THAN | WEB PROGRAMMING</h6>
        </div>
    </footer>
</body>

</html>