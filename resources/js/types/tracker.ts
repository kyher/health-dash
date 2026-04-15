export type Category = {
    id: number;
    name: string;
};

export type TrackerNote = {
    id: number;
    content: string;
    created_at: string;
};

export type TrackerAppointment = {
    id: number;
    appointment_at: string;
};

export type Tracker = {
    id: number;
    name: string;
    category: Category;
    notes: TrackerNote[];
    appointments: TrackerAppointment[];
};
