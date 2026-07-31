export type ToastColor = 'primary' | 'secondary' | 'success' | 'info' | 'warning' | 'error' | 'neutral';

export type FlashToast = {
    type?: ToastColor;
    color?: ToastColor;
    message?: string;
    body?: string;
    icon?: string;
};
