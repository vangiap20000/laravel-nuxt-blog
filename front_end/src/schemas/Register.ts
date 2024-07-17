import { z } from 'zod';

export const RegisterValidationSchema = z.object({
	name: z.string().min(1, { message: 'Name is required' }).max(255),
	email: z.string().min(1, { message: 'Email is required' }).email().max(255),
	password: z.string().min(8, { message: 'Min length is 8' }),
	password_confirmation: z.string(),
})
.refine((data) => data.password === data.password_confirmation, {
	message: "Passwords don't match",
	path: ["password_confirmation"], // path of error
});
