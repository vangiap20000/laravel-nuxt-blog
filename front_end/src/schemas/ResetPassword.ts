import { z } from 'zod';

export const RegisterValidationSchema = z.object({
	email: z.string().min(1, { message: 'Email is required' }),
})
