export type Category = {
    id: number;
    name: string;
};

export type Tracker = {
    id: number;
    name: string;
    category: Category;
};
