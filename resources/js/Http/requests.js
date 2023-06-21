export const fetchTasks = ({ page = 1, }) => {
    const params = { page };

    return axios.get('/api/tasks', { params });
};

export const fetchTask = (id) => {
    return axios.get(`/api/tasks/${id}`);
};

export const createTask = (form) => {
    return axios.post(`/api/tasks`, form);
};

export const editTask = (id, form) => {
    return axios.patch(`/api/tasks/${id}`, form);
};

export const deleteTask = (id) => {
    return axios.delete(`/api/tasks/${id}`);
};
