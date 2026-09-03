import { cn } from "@/lib/utils";

interface InputProps extends React.TextareaHTMLAttributes<HTMLTextAreaElement> | React.InputHTMLAttributes<HTMLInputElement> {
  className?: string;
}

const Input = React.forwardRef<HTMLInputElement | HTMLTextAreaElement, InputProps>({
  className: "flex flex-col w-full rounded-md border border-input px-3 py-2 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-input disabled:opacity-50 disabled:cursor-not-allowed",
  ...props,
}) => {
  const { className, ...inputProps } = props;
  return (
    <input
      className={cn("flex flex-col w-full rounded-md border border-input px-3 py-2 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-input disabled:opacity-50 disabled:cursor-not-allowed", className)}
      {...inputProps}
    />
  );
});

Input.displayName = "Input";

export { Input };
