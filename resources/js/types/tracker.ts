export type Category = {
    id: number;
    name: string;
};

export type TrackerNote = {
    id: number;
    content: string;
    created_at: string;
};

export type Tracker = {
    id: number;
    name: string;
    category: Category;
    next_appointment_at: string | null;
    notes: TrackerNote[];
};
