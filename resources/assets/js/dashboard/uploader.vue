<template>
    <div class="uploader">
        <a href="#upload-modal"
            class="fixed-action-btn btn-floating btn-large waves-effect waves-light blue tooltipped"
            data-position="left"
            data-delay="50"
            :data-tooltip="$trans('upload')">
            <i class="material-icons">image</i>
        </a>
        <div id="upload-modal" class="modal">
            <div class="modal-content">
                <blockquote>
                    <p>Make sure you have already created the symbolic link 
                        <code>public/storage</code> 
                        target 
                        <code>storage/app/public</code> 
                        before uploading any images.Otherwise no image will be accessible.
                    </p>
                    <p>Not yet? run</p>
                    <pre>ln -s /path/to/storage/app/public/ public/storage</pre>
                </blockquote>

                <div class="collection" v-if="images.length">
                    <div class="collection-item" :class="image.status" v-for="image in images">
                        <div class="row valign-wrapper">
                            <div class="col s3">{{ image.name }}</div>
                            <div class="col s8">
                                <span class="uploader__item" v-if="image.status === 'success'">
                                    ![{{ image.name }}]({{ image.link }})
                                    <button class="copy blue-text" @click="copy($event, image)">copy</button>
                                </span>
                            </div>
                            <div class="col s1 valign-wrapper">
                                <i class="material-icons green-text" v-if="image.status === 'success'">check_circle</i>
                                <i class="material-icons yellow-text rotate" v-else-if="image.status === 'processing'">autorenew</i>
                                <i class="material-icons red-text tooltipped" data-position="bottom" :data-tooltip="image.error" data-delay="10" v-else-if="image.status === 'failed'">error</i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="file-field input-field">
                        <div class="btn uploader__btn">
                            <span>Image</span>
                            <input type="file" multiple @change="uploadImages">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data () {
            return {
                images: []
            }
        },

        mounted() {
            $('#upload-modal').modal();
        },

        methods: {
            uploadImages(event) {
                let images = event.srcElement.files;
                for (let i = 0; i < images.length; i++) {
                    let image  = images.item(i);
                    let form = new FormData();
                    form.append('image', image);
                    let imageData = {
                        name: image.name.substr(0, image.name.lastIndexOf('.')),
                        status: 'processing',
                    }
                    this.images.push(imageData);

                    this.$http.post(`/api/dashboard/assets/images`, form)
                        .then(response => {
                            imageData.status = 'success';
                            imageData.link = response.body.link;
                        }, response => {
                            imageData.status = 'failed';
                            imageData.error = response.body.errors.image;
                            this.$nextTick(() => {
                                $('.tooltipped').tooltip();
                            });
                        });
                }
                event.srcElement.value = null;
            },
            copy($event, image) {
                let body = document.getElementsByTagName('body')[0];
                let input = document.createElement('input');
                body.appendChild(input);
                input.value = `![${image.name}](${image.link})`;
                input.select();
                document.execCommand('copy');
                input.remove();

                this.copied($event.srcElement);
            },
            copied(el) {
                let rect = el.getBoundingClientRect();
                let span = document.createElement('span');
                span.setAttribute('class', 'blue-text copied')
                let text = document.createTextNode('copied');
                span.appendChild(text);

                el.parentElement.appendChild(span);
                setTimeout(() => {
                    span.style.opacity = 0;
                    setTimeout(() => {
                        span.remove();
                    }, 1000);
                }, 100);
            }
        }
    }
</script>