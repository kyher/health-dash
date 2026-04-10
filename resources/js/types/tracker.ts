export type Category = {
    id: number;
    name: string;
};

export type Tracker = {
    id: number;
    name: string;
    category: Category;
    next_appointment_at: string | null;
};
