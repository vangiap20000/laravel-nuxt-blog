import { z } from 'zod';

export const RegisterValidationSchema = z.object({
  title: z.string().min(1, { message: 'Field is required' }).max(255),
  content: z.string(),
  type: z.number().int(),
  status: z.number().int(),
});
