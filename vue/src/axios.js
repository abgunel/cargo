/*import axios from "axios";
export const api {
    axios.defaults.withCredentials = true;
axios.defaults.baseURL = "http://localhost:80/api/";
}


export default api;*/


import axios from "axios";

export const domainAddress = "http://localhost:80";
//export const baseApiURL = domainAddress + "/api/";
//axios.defaults.withCredentials = true;
//export const domainAddress = "";
export const baseApiURL = domainAddress + "/api/";

export const api = axios.create({
  baseURL: baseApiURL,
});
//export const api = axios.create();

export default api;