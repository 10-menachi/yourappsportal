const axiosWithLoader = axios.create();
axiosWithLoader.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axiosWithLoader.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

axiosWithLoader.interceptors.request.use(function (config) {
    // Do something before request is sent
    showLoader();
    return config;
}, function (error) {
    hideLoader();
    // Do something with request error
    return Promise.reject(error);
});

axiosWithLoader.interceptors.response.use(function (response) {
    hideLoader();
    return response;
}, function (error) {
    hideLoader();
    return Promise.reject(error);
});

function showLoader(){
    $.LoadingOverlay("show");
}
function hideLoader(){
    $.LoadingOverlay("hide");
}