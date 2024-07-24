import { z } from 'zod';

export const RegisterValidationSchema = z.object({
    name: z.string().min(1, { message: 'Name is required' }).max(255),
    about: z.string().min(1, { message: 'Description is required' }),
    users: z.array(z.number()).nonempty({ message: 'Members is required' }),
});
