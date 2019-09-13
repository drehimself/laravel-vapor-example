<template>
    <form method="post" action="/submit" enctype="multipart/form-data" @submit.prevent="uploadFile">
        <input type="file" name="file" id="file" ref="file">
        <button type="submit">Upload File</button>
        <div>{{ uploadProgress }}</div>
    </form>
</template>

<script>
    export default {
        data() {
            return {
               uploadProgress: 0
            }
        },
        methods: {
            uploadFile() {
                Vapor.store(this.$refs.file.files[0], {
                    progress: progress => {
                        this.uploadProgress = Math.round(progress * 100);
                    }
                }).then(response => {
                    axios.post('/submit', {
                        uuid: response.uuid,
                        key: response.key,
                        bucket: response.bucket,
                        name: this.$refs.file.files[0].name,
                        content_type: this.$refs.file.files[0].type,
                    })
                    console.log('Upload complete')
                });
            }
        }
    }
</script>
