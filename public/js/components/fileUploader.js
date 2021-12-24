class FileUploader {

    constructor(url) {
        this.dropzoneEl = new Dropzone('#kt_dropzone_1',{
            url: '/', // Set the url for your upload script location
            type:'post',
            paramName: "file", // The name that will be used to transfer the file
            maxFiles: 1,
            maxFilesize: 5, // MB
            addRemoveLinks: true,
            autoProcessQueue: false,
                          

            // init: function () {
            //     this.dropzoneEl = this;
            // },
            sending: function(file, xhr, formData) {
                formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
                formData.append("start_date", $('#start_date').val());
                formData.append("end_date", $('#end_date').val());
                formData.append("noti_expiry", $('#noti_expiry').val());
            },

        });
    }

    uploadFile(url){
        this.dropzoneEl.options.url = url;
        this.dropzoneEl.processQueue();
    }
}
